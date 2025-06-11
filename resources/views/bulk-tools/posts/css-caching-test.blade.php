<!-- post page blog start -->
<div class="single-post-content-main">
  <div class="single-post-content">
    <h2 class="tools_des_fastheading">How to pass the CSS caching test?</h2>
    <p>
      The concept of inline caching is based on the empirical observation that the objects that occur at a particular call site are often of the same type. In those cases, performance can be increased greatly by storing the result of a method lookup "inline"; i.e., directly at the call site. To facilitate this process, call sites are assigned different states. Initially, a call site is considered to be "uninitialized". Once the language runtime reaches a particular uninitialized call site, it performs the dynamic lookup, stores the result at the call site and changes its state to "monomorphic". If the language runtime reaches the same call site again, it retrieves the callee from it and invokes it directly without performing any more lookups. To account for the possibility that objects of different types may occur at the same call site, the language runtime also has to insert guard conditions into the code. Most commonly, these are inserted into the preamble of the callee rather than at the call site to better exploit branch prediction and to save space due to one copy in the preamble versus multiple copies at each call site. If a call site that is in the "monomorphic" state encounters a type other than the one it expects, it has to change back to the "uninitialized" state and perform a full dynamic lookup again. </p>
    
  </div>
</div>
<!-- post page blog end -->