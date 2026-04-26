window.addEventListener("load", () => {
    (function () {
        const container = document.querySelector(".CPC-C-sidebar-inner");
        const thumb = document.querySelector(".CPC-C-sidebar-thumb");

        function updateThumb() {
        if (!container || !thumb) return;

        const visible = container.clientHeight;
        const total = container.scrollHeight;

        if (total === 0) return;

        const thumbHeight = (visible / total) * visible;
        thumb.style.height = thumbHeight + "px";
        }

        function moveThumb() {
            if (!container || !thumb) return;

            const scrollTop = container.scrollTop;
            const totalScroll = container.scrollHeight - container.clientHeight;

            if (totalScroll <= 0) {
                thumb.style.top = "0px";
                return;
            }

            const thumbTop =
                (scrollTop / totalScroll) *
                (container.clientHeight - thumb.clientHeight);

            thumb.style.top = thumbTop + "px";

            console.log({
            scrollTop,
            totalScroll,
            thumbHeight: thumb.clientHeight,
            containerHeight: container.clientHeight
            });
        }

        if (container) {
        container.addEventListener("scroll", moveThumb);
        }

        const tabs = document.querySelectorAll(".siteAudit-tab");
        const underline = document.getElementById("siteAuditUnderline");
        const header = document.querySelector(".siteAuditHeaderDiv-d1");

        function moveUnderline(el){
            underline.style.width = el.offsetWidth + "px";
            underline.style.left = el.offsetLeft + "px";
        }

        function toggleHeader(tab){
            if(tab.dataset.tab === "siteAuditOverview"){
                header.style.display = "flex"; 
            } else {
                header.style.display = "none";
            }
        }

        const activeTab = document.querySelector(".siteAudit-tab.active");
        if(activeTab){
            moveUnderline(activeTab);
            toggleHeader(activeTab);
        }

        tabs.forEach(tab => {
            tab.addEventListener("click", function(){
                document.querySelector(".siteAudit-tab.active").classList.remove("active");
                this.classList.add("active");

                moveUnderline(this);
                toggleHeader(this);
                requestAnimationFrame(() => {
                updateThumb();
                moveThumb();
                });
            });
        });

        let isDraggingThumb = false;
let startY = 0;
let startScrollTop = 0;

thumb.addEventListener("mousedown", startDragThumb);

function startDragThumb(e) {
    isDraggingThumb = true;
    startY = e.clientY;
    startScrollTop = container.scrollTop;

    document.addEventListener("mousemove", onDragThumb);
    document.addEventListener("mouseup", stopDragThumb);

    e.preventDefault(); // prevent text selection
}

function onDragThumb(e) {
    if (!isDraggingThumb) return;

    const deltaY = e.clientY - startY;

    const totalScroll = container.scrollHeight - container.clientHeight;
    const trackHeight = container.clientHeight - thumb.clientHeight;

    if (trackHeight <= 0) return;

    container.scrollTop =
        startScrollTop + (deltaY / trackHeight) * totalScroll;
}

function stopDragThumb() {
    isDraggingThumb = false;

    document.removeEventListener("mousemove", onDragThumb);
    document.removeEventListener("mouseup", stopDragThumb);
}
})();
    
(function () {
const tabs = document.querySelectorAll(".siteAudit-tab");
const underline = document.getElementById("siteAuditUnderline");
const contents = document.querySelectorAll(".siteAudit-tab-content");

if (!tabs.length || !underline) return; 

const moveUnderline = (el) => {
    underline.style.width = el.offsetWidth + "px";
    underline.style.left = el.offsetLeft + "px";
};

const setActiveUnderline = () => {
    const activeTab = document.querySelector(".siteAudit-tab.active");
    if (activeTab) moveUnderline(activeTab);
};

// Initial position
setActiveUnderline();

tabs.forEach(tab => {
    tab.addEventListener("click", function () {

        const currentActive = document.querySelector(".siteAudit-tab.active");
        if (currentActive) currentActive.classList.remove("active");

        this.classList.add("active");

        moveUnderline(this);

        const target = this.getAttribute("data-tab");

        contents.forEach(c => c.classList.remove("active"));

        const targetEl = document.getElementById(target);
        if (targetEl) targetEl.classList.add("active");
    });
});

// 🔥 Recalculate on resize
window.addEventListener("resize", () => {
    setActiveUnderline();
});

})();

(function (){
  const dropdown = document.querySelector(".siteAuditCC-d1-d2-iconDropdown1");
  const menu = document.querySelector(".siteAuditCC-d1-d2-iconDropdown1-menu");

  function showMenu(){
      menu.classList.add("show");
  }

  function hideMenu(){
      menu.classList.remove("show");
  }

  dropdown.addEventListener("mouseenter", showMenu);
  dropdown.addEventListener("mouseleave", hideMenu);
  menu.addEventListener("mouseenter", showMenu);
  menu.addEventListener("mouseleave", hideMenu);
})()
    

    // Adding indecing and padding to the 4th td of the 7th table tbody td
function applyTableLogic() {
    document.querySelectorAll('.SA-IT-tables-4thcol td:nth-child(4)')
    .forEach(td => {
        const div = td.querySelector('div');
        const ps = div.querySelectorAll('p');

        if (ps.length > 1) {
            // 👇 only change here
            td.style.paddingLeft = window.innerWidth <= 400 ? "17px" : "22px";

            ps.forEach((p, index) => {
                if (!p.dataset.indexed) {
                    p.classList.add('indexed');
                    p.setAttribute('data-index', index + 1);
                    p.dataset.indexed = "true";
                }
            });
        }
    });
}
applyTableLogic();
window.addEventListener('resize', applyTableLogic);


  
});
  
(function () {
const circle = document.querySelector(".gradientLayer");
const startAngle = 246;
const visibleArc = 229;

const numberEl = document.getElementById("OC-d1-SH-d2-MC-Id1-h1");
const labelEl = document.getElementById("OC-d1-SH-d2-MC-Id1-h6");

function animateProgress(targetPercent) {
    // Reset circle to pure gray first
    circle.style.background = `conic-gradient(from ${startAngle}deg, #E1E1E1 0deg, #E1E1E1 360deg)`;
    numberEl.textContent = "0";
    labelEl.textContent = "";

    let start = null;

    function step(timestamp) {
        if (!start) start = timestamp;
        let progress = (timestamp - start) / 1000; // 1 second duration
        let value = Math.min(progress * targetPercent, targetPercent);

        // Calculate the conic-gradient degree
        let deg = (value / 100) * visibleArc;

        if (deg <= 0) {
            circle.style.background = `conic-gradient(
                from ${startAngle}deg,
                #E1E1E1 0deg,
                #E1E1E1 360deg
            )`;
        } else if (deg < 1) {
            circle.style.background = `conic-gradient(
                from ${startAngle}deg,
                #4EB37B ${deg}deg,
                #E1E1E1 ${deg}deg 360deg
            )`;
        } else {
            circle.style.background = `conic-gradient(
                from ${startAngle}deg,
                #E1E1E1 0deg,
                #4EB37B 1deg,
                #4EB37B ${deg - 0.5}deg,
                #E1E1E1 ${deg + 0.5}deg,
                #E1E1E1 360deg
            )`;
        }

        numberEl.textContent = Math.floor(value);

        if (value <= 25) labelEl.textContent = "Poor";
        else if (value <= 50) labelEl.textContent = "Fair";
        else if (value <= 75) labelEl.textContent = "Good";
        else labelEl.textContent = "Excellent";

        if (value < targetPercent) {
            requestAnimationFrame(step);
        }
    }

    requestAnimationFrame(step);
}
animateProgress(40);

})();


function runRectAnimation() {

        // These take the values we put in the html just in case amit asks!
  const val1 = parseInt(document.querySelector(".OC-d2-d3-d2-d-p").textContent); // Broken (RED)
  const val2 = parseInt(document.querySelector(".OC-d2-d3-d1-d-p").textContent); // Healthy (GREEN)
  const val3 = parseInt(document.querySelector(".OC-d2-d3-d3-d-p").textContent); // Issues (ORANGE)
  const val4 = parseInt(document.querySelector(".OC-d2-d3-d4-d-p").textContent); // Redirect (BLUE)

  const total = val1 + val2 + val3 + val4;

  const p1 = (val1 / total) * 100;
  const p2 = (val2 / total) * 100;
  const p3 = (val3 / total) * 100;
  const p4 = (val4 / total) * 100;

  const r1 = document.getElementById("overviewContent-d2-d2-rect1");
  const r2 = document.getElementById("overviewContent-d2-d2-rect2");
  const r3 = document.getElementById("overviewContent-d2-d2-rect3");
  const r4 = document.getElementById("overviewContent-d2-d2-rect4");

  r1.style.background = "#E52F34"; // first shit
  r2.style.background = "#4EB37B"; // second shit
  r3.style.background = "#FEB36C"; // thirs shit
  r4.style.background = "#3A7CEC"; // fourth shit

  setTimeout(() => {
    r1.style.width = p1 + "%";
  }, 100);

  setTimeout(() => {
    r2.style.width = p2 + "%";
  }, 400);

  setTimeout(() => {
    r3.style.width = p3 + "%";
  }, 700);

  setTimeout(() => {
    r4.style.width = p4 + "%";
  }, 1000);
}
document.addEventListener("DOMContentLoaded", runRectAnimation);
function animateCount(el, duration = 1000) {
    const target = parseInt(el.textContent);
    let start = 0;
    const increment = target / (duration / 16);

    const counter = setInterval(() => {
        start += increment;

        if (start >= target) {
            el.textContent = target;
            clearInterval(counter);
        } else {
            el.textContent = Math.floor(start);
        }
    }, 16);
}

document.addEventListener("DOMContentLoaded", () => {
    const red = document.getElementById("overviewContent-d3-d2-Div-d1-red");
    const yellow = document.getElementById("overviewContent-d3-d2-Div-d1-yellow");
    const blue = document.getElementById("overviewContent-d3-d2-Div-d1-blue");

    animateCount(red, 1200);
    animateCount(yellow, 1200);
    animateCount(blue, 1200);
});

document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => {
    document.querySelector("#OC-b-d1-d2-d2-rc-d1-d1 .OC-b-d1-d2-d2-rc-d1-d1-fill").style.width = "80%";
    document.querySelector("#OC-b-d1-d2-d2-rc-d1-d2 .OC-b-d1-d2-d2-rc-d1-d1-fill").style.width = "7%";
    document.querySelector("#OC-b-d1-d2-d2-rc-d1-d3 .OC-b-d1-d2-d2-rc-d1-d1-fill").style.width = "13%";
  }, 200);
});

function updateDonutChart() {
  const rows = document.querySelectorAll(
    ".OC-b-d2-d2-tableCont table tbody tr"
  );

  let values = [];

  rows.forEach((row) => {
    const percentText = row.querySelector("td:nth-child(3) p").textContent;
    const value = parseFloat(percentText);
    values.push((value / 100) * 360); // convert to degrees
  });

  const circle = document.querySelector(".OC-b-d2-d2-arcCont-circle1");

  // assign each segment
  circle.style.setProperty("--p1", values[0] + "deg");
  circle.style.setProperty("--p2", values[1] + "deg");
  circle.style.setProperty("--p3", values[2] + "deg");
  circle.style.setProperty("--p4", values[3] + "deg");
  circle.style.setProperty("--p5", values[4] + "deg");

  // trigger animation
  setTimeout(() => {
    circle.style.setProperty("--progress", 1);
  }, 100);
}
document.addEventListener("DOMContentLoaded", updateDonutChart);

function crampledPagesDropdownFunc() {
    const top2 = document.querySelector(".CPC-top2");
    const top2Btn = document.querySelector(".CPC-top2-d2");
    const top3 = document.querySelector(".CPC-top3");
    const top3Btn = document.querySelector(".CPC-top3-d2");
    top2Btn.addEventListener("click", () => {
    top2.classList.toggle("active");
    });
    top3Btn.addEventListener("click", () => {
    top3.classList.toggle("active");
    });
    const checkboxes = document.querySelectorAll(
    ".CPC-top2-d3-d1-checkbox, .CPC-top3-d3-d1-checkbox"
    );
    checkboxes.forEach(box => {
    box.addEventListener("click", () => {
        box.classList.toggle("active");

        updateIndicator(top2, ".CPC-top2-d1");
        updateIndicator(top3, ".CPC-top3-d1");
    });
    });
    function updateIndicator(container, indicatorSelector) {
    const indicator = container.querySelector(indicatorSelector);
    const count = container.querySelectorAll(".active").length;
    if (count > 0) {
        indicator.style.display = "flex";
        indicator.style.alignItems = "center";
        indicator.style.justifyContent = "space-between";
        indicator.querySelector("p:first-child").textContent = count;
    } else {
        indicator.style.display = "none";
    }
    }
}
crampledPagesDropdownFunc();


function hideShowSATableCont(){

    // For closing/opening the issue desc
    document.querySelector("#CPC-C-DT-d1-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d1-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d2-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d2-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d3-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d3-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d4-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d4-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d5-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d5-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d6-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d6-d2").classList.toggle("active");
    })
    document.querySelector("#CPC-C-DT-d7-d1-d1-p").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d7-d2").classList.toggle("active");
    })

    // For closing/opening the section 
    document.querySelector(".CPC-C-DT-d1-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d1-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d1-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d2-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d2-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d2-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d3-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d3-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d3-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d4-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d4-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d4-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d5-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d5-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d5-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d6-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d6-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d6-d1-d2-arrow").classList.toggle("active");
    })
    document.querySelector(".CPC-C-DT-d7-d1-d2-arrow").addEventListener("click", ()=> {
        document.querySelector(".CPC-C-DT-d7-d3").classList.toggle("active");
        document.querySelector(".CPC-C-DT-d7-d1-d2-arrow").classList.toggle("active");
    })


}
hideShowSATableCont();


(function () {

    const tables = document.querySelectorAll(".SA-IT-tables");

    tables.forEach((wrapper) => {

        const rowsPerPage = 10;

        const tbody = wrapper.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));

        const paginationContainer = wrapper.querySelector(".CPC-C-DT-d1-d3-Bottom-d1");

        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function showPage(page) {
            currentPage = page;

            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.style.display = "table-row";

                    const firstTd = row.querySelector("td:first-child");

                    if (firstTd) {
                        const p = firstTd.querySelector("p");

                        if (p) {
                            p.textContent = index + 1;
                        } else {
                            firstTd.textContent = index + 1;
                        }
                    }

                } else {
                    row.style.display = "none";
                }
            });

            updateActiveBtn();
        }

        function createPagination() {
            paginationContainer.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("div");
                const p = document.createElement("p");

                p.textContent = i;
                btn.appendChild(p);

                btn.addEventListener("click", () => showPage(i));

                paginationContainer.appendChild(btn);
            }
        }

        function updateActiveBtn() {
            const buttons = paginationContainer.querySelectorAll("div");

            buttons.forEach((btn, index) => {
                btn.classList.toggle("active", index === currentPage - 1);
            });
        }

        createPagination();
        showPage(1);

    });

})();

// For making the sidebar cards active and scrolling the relevant display tabs into view!
(function () {
  const cards = document.querySelectorAll('.CPC-C-sidebar-card');
  const displayInner = document.querySelector('.CPC-C-display-inner');
  const sidebarInner = document.querySelector('.CPC-C-sidebar-inner');

  cards.forEach(card => {
    card.addEventListener('click', () => {
      const target = card.dataset.issuestab;

      // Active state
      cards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');

      const offset = 120;

      // 👉 Scroll MAIN PAGE
      if (target === "all") {
        const top = displayInner.getBoundingClientRect().top + window.pageYOffset - offset;

        window.scrollTo({
          top,
          behavior: 'smooth'
        });
      } else {
        const tab = document.querySelector(
          `.CPC-C-display-tab[data-issuestab="${target}"]`
        );

        if (tab) {
          const top = tab.getBoundingClientRect().top + window.pageYOffset - offset;

          window.scrollTo({
            top,
            behavior: 'smooth'
          });
        }
      }

      
      const cardTop = card.offsetTop;

      sidebarInner.scrollTo({
        top: cardTop,
        behavior: 'smooth'
      });
    });
  });
})();


function initCRPTable(rowsPerPage) {
  const rows = document.querySelectorAll('.CRP-Table tbody tr');
  const paginationContainer = document.querySelector('.CRP-T-d1-d1');

  let currentPage = 1;
  const totalPages = Math.ceil(rows.length / rowsPerPage);

  function render(page) {
  currentPage = page;

  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;

  let visibleIndex = 1;
  let lastVisibleRow = null;

  rows.forEach((row, index) => {
    const isVisible = index >= start && index < end;
    row.style.display = isVisible ? '' : 'none';

    if (isVisible) {
      lastVisibleRow = row;
      const indexCell = row.querySelector('td:nth-child(1) p');
      if (indexCell) indexCell.textContent = visibleIndex++;
    }

    row.querySelectorAll('td').forEach(td => {
      td.style.borderBottom = '1px solid #F4F4F4';
    });
  });

  if (lastVisibleRow) {
    lastVisibleRow.querySelectorAll('td').forEach(td => {
      td.style.borderBottom = '1px solid #DDDDDD';
    });
  }
  const buttons = paginationContainer.querySelectorAll('.CRP-T-d1-d1-pagination');
  buttons.forEach((btn, i) => {
    btn.classList.toggle('active', i + 1 === currentPage);
  });
}
  paginationContainer.innerHTML = '';

  for (let i = 1; i <= totalPages; i++) {
    const div = document.createElement('div');
    div.className = 'CRP-T-d1-d1-pagination';

    const p = document.createElement('p');
    p.textContent = i;

    div.appendChild(p);

    div.addEventListener('click', () => render(i));

    paginationContainer.appendChild(div);
  }

  render(1);
} initCRPTable(10);

(function () {
    const rowsPerPage = 10;

const table = document.querySelector('.AudC-d2 table tbody');
const allRows = Array.from(table.querySelectorAll('tr'));

const paginationContainer = document.querySelector('.AudC-d3-d1');
const leftBtn = document.querySelector('.AudC-d3-d1-left');
const rightBtn = document.querySelector('.AudC-d3-d1-right');

let currentPage = 1;
const totalPages = Math.ceil(allRows.length / rowsPerPage);

let paginationButtons = [];
function addIndexing(rows, startIndex) {
  rows.forEach((row, i) => {
    const indexCell = row.querySelector('td:first-child p');
    if (indexCell) {
      indexCell.textContent = startIndex + i + 1;
    }
  });
}
function renderTable() {
  table.innerHTML = '';

  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;

  const pageRows = allRows.slice(start, end);

  pageRows.forEach(row => table.appendChild(row));

  addIndexing(pageRows, start);
}

function renderPagination() {
  paginationButtons.forEach(btn => btn.remove());
  paginationButtons = [];

  for (let i = 1; i <= totalPages; i++) {
    const btn = document.createElement('div');
    btn.className = 'AudC-d3-d1-pagination';

    const p = document.createElement('p');
    p.textContent = i;

    btn.appendChild(p);

    if (i === currentPage) {
      btn.classList.add('active');
    }

    btn.addEventListener('click', () => {
      currentPage = i;
      update();
    });

    paginationContainer.insertBefore(btn, rightBtn);
    paginationButtons.push(btn);
  }
}
function update() {
  renderTable();
  renderPagination();
  if (currentPage > 1) {
    leftBtn.classList.add('active');
  } else {
    leftBtn.classList.remove('active');
  }
  if (currentPage < totalPages) {
    rightBtn.classList.add('active');
  } else {
    rightBtn.classList.remove('active');
  }
}
leftBtn.addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    update();
  }
});

rightBtn.addEventListener('click', () => {
  if (currentPage < totalPages) {
    currentPage++;
    update();
  }
});
update();
})();


(function () {
    const searchInput = document.querySelector('.CPC-top1 input');
const items = document.querySelectorAll('.ST-IT-searchableIssues');
searchInput.addEventListener('input', () => {
  const value = searchInput.value.toLowerCase().trim();

  items.forEach(item => {
    const text = item.textContent.toLowerCase();

    if (text.includes(value)) {
      item.style.display = '';
    } else {
      item.style.display = 'none';
    }
  });
});
const searchInput2 = document.querySelector('.AudC-d1 input');
const rows = document.querySelectorAll('.AudC-d2 tbody tr');

searchInput2.addEventListener('input', () => {
  const value = searchInput2.value.toLowerCase().trim();

  rows.forEach(row => {
    const col2 = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
    const col3 = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

    if (col2.includes(value) || col3.includes(value)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
})();


function updateLastUpdated(elementId = 'lastUpdated') {
  const now = new Date();

  const date = now.toLocaleDateString('en-US', {
    month: 'short',
    day: '2-digit',
    year: 'numeric'
  });

  const time = now.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  });

  const el = document.getElementById(elementId);
  if (el) {
    el.textContent = `Last Updated: ${date} ${time}`;
  }
}
updateLastUpdated();