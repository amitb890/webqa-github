/**
 * IndexedDB cache for dashboard widget aggregates and tracker/report table payloads.
 * Invalidated when dashboard_cache_revision changes (after recheck or new test run).
 */
(function (global) {
  var DB_NAME = "webqa_dashboard_tracker_view_v1";
  var STORE = "kv";
  var SCHEMA = 1;

  function openDb() {
    return new Promise(function (resolve, reject) {
      var req = indexedDB.open(DB_NAME, 1);
      req.onerror = function () {
        reject(req.error);
      };
      req.onsuccess = function () {
        resolve(req.result);
      };
      req.onupgradeneeded = function (e) {
        var db = e.target.result;
        if (!db.objectStoreNames.contains(STORE)) {
          db.createObjectStore(STORE);
        }
      };
    });
  }

  function txDone(tx) {
    return new Promise(function (resolve, reject) {
      tx.oncomplete = function () {
        resolve();
      };
      tx.onerror = function () {
        reject(tx.error);
      };
      tx.onabort = function () {
        reject(tx.error || new Error("aborted"));
      };
    });
  }

  function withStore(mode, fn) {
    return openDb().then(function (db) {
      return new Promise(function (resolve, reject) {
        var tx;
        try {
          tx = db.transaction(STORE, mode);
        } catch (e) {
          db.close();
          reject(e);
          return;
        }
        var store = tx.objectStore(STORE);
        Promise.resolve(fn(store))
          .then(function (ret) {
            return txDone(tx).then(function () {
              db.close();
              resolve(ret);
            });
          })
          .catch(function (err) {
            try {
              tx.abort();
            } catch (_) {}
            db.close();
            reject(err);
          });
      });
    });
  }

  function keyDashboard(projectId) {
    return "dashboard:" + projectId;
  }

  function keyTracker(projectId) {
    return "tracker:" + projectId;
  }

  global.WebqaViewCache = {
    isSupported: function () {
      return typeof indexedDB !== "undefined";
    },

    getDashboard: function (projectId, serverRevision) {
      if (!this.isSupported() || serverRevision == null) {
        return Promise.resolve(null);
      }
      var self = this;
      return withStore("readonly", function (store) {
        return new Promise(function (resolve, reject) {
          var r = store.get(keyDashboard(projectId));
          r.onsuccess = function () {
            var rec = r.result;
            if (!rec || rec.v !== SCHEMA || rec.revision !== serverRevision) {
              resolve(null);
              return;
            }
            resolve(rec);
          };
          r.onerror = function () {
            reject(r.error);
          };
        });
      }).catch(function () {
        return null;
      });
    },

    mergeDashboard: function (projectId, patchOrFn) {
      if (!this.isSupported()) {
        return Promise.resolve();
      }
      var k = keyDashboard(projectId);
      return withStore("readwrite", function (store) {
        return new Promise(function (resolve, reject) {
          var gr = store.get(k);
          gr.onsuccess = function () {
            var base = gr.result && gr.result.v === SCHEMA ? gr.result : { v: SCHEMA };
            var isFn = typeof patchOrFn === "function";
            var patch = isFn ? patchOrFn(base) : patchOrFn;
            var next;
            if (isFn) {
              next = Object.assign({ v: SCHEMA }, patch);
            } else {
              next = Object.assign({}, base, patch, { v: SCHEMA });
              if (patch.cardDetails) {
                next.cardDetails = Object.assign({}, base.cardDetails || {}, patch.cardDetails);
              }
              if (patch.google != null) {
                next.google = Object.assign({}, base.google || {}, patch.google);
              }
            }
            var pr = store.put(next, k);
            pr.onsuccess = function () {
              resolve();
            };
            pr.onerror = function () {
              reject(pr.error);
            };
          };
          gr.onerror = function () {
            reject(gr.error);
          };
        });
      }).catch(function () {});
    },

    setTracker: function (projectId, record) {
      if (!this.isSupported()) {
        return Promise.resolve();
      }
      var k = keyTracker(projectId);
      return withStore("readwrite", function (store) {
        return new Promise(function (resolve, reject) {
          var rec = Object.assign({ v: SCHEMA }, record);
          var pr = store.put(rec, k);
          pr.onsuccess = function () {
            resolve();
          };
          pr.onerror = function () {
            reject(pr.error);
          };
        });
      }).catch(function () {});
    },

    getTracker: function (projectId, serverRevision) {
      if (!this.isSupported() || serverRevision == null) {
        return Promise.resolve(null);
      }
      return withStore("readonly", function (store) {
        return new Promise(function (resolve, reject) {
          var r = store.get(keyTracker(projectId));
          r.onsuccess = function () {
            var rec = r.result;
            if (!rec || rec.v !== SCHEMA || rec.revision !== serverRevision) {
              resolve(null);
              return;
            }
            resolve(rec);
          };
          r.onerror = function () {
            reject(r.error);
          };
        });
      }).catch(function () {
        return null;
      });
    },

    invalidateProject: function (projectId) {
      if (!this.isSupported()) {
        return Promise.resolve();
      }
      var dk = keyDashboard(projectId);
      var tk = keyTracker(projectId);
      return withStore("readwrite", function (store) {
        return new Promise(function (resolve, reject) {
          var c = 0;
          function step(err) {
            if (err) {
              reject(err);
              return;
            }
            c++;
            if (c === 2) {
              resolve();
            }
          }
          var d1 = store.delete(dk);
          d1.onsuccess = function () {
            step();
          };
          d1.onerror = function () {
            step(d1.error);
          };
          var d2 = store.delete(tk);
          d2.onsuccess = function () {
            step();
          };
          d2.onerror = function () {
            step(d2.error);
          };
        });
      }).catch(function () {});
    },
  };
})(typeof window !== "undefined" ? window : this);
