@extends('layouts.master')

@section('title', 'About us - Page')
@section('meta-description', 'This is features page meta description.')

@section("content")

        <!--Section 1 starts -->
        <section class="as1">
                <div class="as1-left">
                    <img class="as1-left-img1"  src="{{ asset('new-assets/assets/images/aboutUs/as1-left-img.svg') }}" alt="">
                    <img class="as1-left-img2"  src="{{ asset('new-assets/assets/images/aboutUs/as1-left-img-absolute.svg') }}" alt="">
                </div>
                <div class="as1-center">
                    <h1 class="as1-center-h1">We simplify <span style="color: #417cec;">SEO</span> for smarter growth</h1>
                    <p class="as1-center-p">Making digital businesses accessible through innovative solutions</p>
                </div>
                <div class="as1-right">
                    <img class="as1-right-img2" src="{{ asset('new-assets/assets/images/aboutUs/as1-right-img-absolute.svg') }}" alt="">
                    <img class="as1-right-img1"  src="{{ asset('new-assets/assets/images/aboutUs/as1-right-img.svg') }}" alt="">
                </div>
        </section>
        <!-- Section 1 ends -->

        <!-- Section 2 starts -->
        <section class="as2 container-fluid">
            <div class="container-fluid as2-inner">
                <div class="as2-dtop">
                    <div class="as2-dtop-left">
                        <div class="as2-dtop-left-hs">
                            <h1 style="color: #fff;">Who we are</h1>
                            <h1 style="color: #fff;">and what we do</h1>
                        </div>
                        <p class="as2-dtop-left-p">From small businesses to global enterprises, Web QA is the go-to platform for managing online visibility and accelerating digital growth.</p>
                    </div>
                    <div class="as2-dtop-right">
                        <p class="as2-dtop-right-p1">
                            WebQA allows customers to understand trends, uncover insights, and generate compelling content to improve the reach and effectiveness of their websites and social media pages.
                        </p>
                        <p class="as2-dtop-right-p2">
                            We specialize in results-driven SEO strategies that elevate your digital presence. From keyword research and on-page optimization to high-authority link building and performance analytics, we simplify the complex world of search to deliver measurable growth. Whether you're a startup or an established brand, our tailored solutions are designed to increase visibility, drive organic traffic, and improve your search engine rankings—ethically and effectively. Let us turn your website into your strongest marketing asset.
                        </p>
                    </div>
                    <div class="as2-line1"></div>
                </div>
                <div class="as2-dmid">
                    <div class="as2-dmid-img">
                        <img  src="{{ asset('new-assets/assets/images/aboutUs/Layer-2.svg') }}" alt="">
                    </div>
                    <div class="as2-dmid-right">
                        <h2 class="as2-dmid-right-h" style="color: #fff;">Our Mission</h2>
                        <p class="as2-dmid-right-p">
                            Our calling is to enable global businesses, agencies, and SEO pros to grow effortlessly by delivering a powerful and intuitive SEO platform enhanced with the latest in ML and AI technology.
                        </p>
                    </div>
                    <div class="as2-line2"></div>
                </div>
                <div class="as2-dlast">
                    <div class="as2-dlast-img">
                        <img  src="{{ asset('new-assets/assets/images/aboutUs/Layer-3.svg') }}" alt="">
                    </div>
                    
                    <div class="as2-dlast-right">
                        <h2 class="as2-dlast-right-h" style="color: #fff;">Our Vision</h2>
                        <p class="as2-dlast-right-p">
                            We're building a future where innovative technologies remove the barriers to digital business success, making it intuitive for everyone.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Section 2 ends -->

        <!-- Section 3 starts -->
         <section class="container as3">
            <div class="as3-top">
                <h1 class="as3-top-h">Our features make a difference</h1>
                <p class="as3-top-p">SE Ranking offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
            </div>
            <div class="as3-down">
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-one-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(1).svg') }}" alt="">
                    </div>
                    <h4 class="as3-down-one-h">Keyword rank tracker</h4>
                    <p class="as3-down-one-p">SE Ranking offers solutions for every daily task handled by SEO specialists. We deliver high-precision data so you can make informed decisions.</p>
                    <button class="as3-down-buton">
                        Learn more
                    </button>
                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon2">
                           <img class="as3-down-two-img-div1" src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="">
                           <img class="as3-down-two-img-div2" src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt=""> 
                    </div>
                    <h4 class="as3-down-two-h">Website audit</h4>
                    <p class="as3-down-two-p">Check your website for technical SEO issues and get personalized tips for fixing them. Compare audits to track your optimization progress.</p>
                    <button class="as3-down-buton">
                        Learn more
                    </button>
                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-three-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="">
                    </div>
                    <h4 class="as3-down-three-h">On-Page SEO Checker</h4>
                    <p class="as3-down-three-p">Analyze your pages and learn how to make them rank higher. Get a list of on-page issues and organize them by their severity, or create custom on-page tasks.</p>
                    <button class="as3-down-buton">
                        Learn more
                    </button>
                </div>
                <div class="as3-down-card">
                    <div class="as3-down-card-imgcon">
                        <img class="as3-down-four-img2" src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="">
                    </div>
                    <h4 class="as3-down-four-h">Backlink Checker</h4>
                    <p class="as3-down-four-p">Review any website’s backlink profile. Analyze its backlinks and referring domains for quality and quantity, review anchor texts, and identify.</p>
                    <button class="as3-down-buton">
                        Learn more
                    </button>
                </div>
            </div>
         </section>
        <!-- Section 3 ends -->

        <!-- Secton 4 starts -->
         <section class="as4">
            <div class="container as4-inner">
                <div class="as4-topd">
                    <div class="as4-topd-h">
                        <h1>Explore our</h1>
                        <h1>Tools</h1>
                    </div>
                    <p class="as4-topd-p">
                        Web QA offers solutions for every daily task handled by SEO specialists. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                    </p>
                </div>
                <div class="as4-cards">
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector-(1).svg') }}" alt="">
                        </div>
                        <h4>Meta Description</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(1).svg') }}" alt="">
                        </div>
                        <h4>Broken Links</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="">
                        </div>
                        <h4>Security</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(2).svg') }}" alt="">
                        </div>
                        <h4>Best Practices</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-imgs">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Vector.svg') }}" alt="">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/vector-(1).svg') }}" alt="">
                        </div>
                        <h4>Website Audit</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                    <a href="">
                        <div class="as4-card">
                        <div class="as4-card-img">
                            <img src="{{ asset('new-assets/assets/images/aboutUs/Layer_1-(3).svg') }}" alt="">
                        </div>
                        <h4>Backlink Checker</h4>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    </a>
                </div>
                <button class="as4-button">
                    View All
                </button>
            </div>
         </section>
        <!-- Secton 4 ends -->


        <!-- Section 5 starts -->
         <section class="as5">
            <div class="as5-inner container">
                <div>
                    <h1>Testimonials</h1>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </div>
                <div class="as5-cards-wrapper">
                    <div class="as5-cards">
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-93.svg') }}" alt="">
                                <div class="as5-card-img-p">
                                    <h6>Amit Khurana</h6>
                                    <p>Founder, Techflick Solutions</p>
                                </div>
                            </div>
                            <p class="as5-card-p">"We were lost in search results before working with this team. Their strategic SEO approach brought clarity, results, and a significant uptick in qualified leads."</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-94.svg') }}" alt="">
                                <div class="as5-card-img-p">
                                    <h6>Neha Bansal</h6>
                                    <p>E-commerce Manager</p>
                                </div>
                            </div>
                            <p class="as5-card-p">"We've seen a 150% increase in organic traffic within six months! The team not only improved our rankings but helped us understand SEO in a way that finally made sense."</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-95.svg') }}" alt="">
                                <div class="as5-card-img-p">
                                    <h6>Ankit Mehra</h6>
                                    <p>SEO Manager</p>
                                </div>
                            </div>
                            <p class="as5-card-p">"SEO always felt overwhelming until we partnered with WebQA. They broke everything down, kept us in the loop, and most importantly—got us real results."</p>
                        </div>
                        <div class="as5-card">
                            <div class="as5-card-img">
                                <img src="{{ asset('new-assets/assets/images/aboutUs/Ellipse-95.svg') }}" alt="">
                                <div class="as5-card-img-p">
                                    <h6>Ankit Mehra</h6>
                                    <p>SEO Manager</p>
                                </div>
                            </div>
                            <p class="as5-card-p">"SEO always felt overwhelming until we partnered with WebQA. They broke everything down, kept us in the loop, and most importantly—got us real results."</p>
                        </div>
                    </div>
                </div>
                
                <div class="as5-bottom">
                    <div class="as5-bottom1">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/left-arrow.svg') }}" alt="">
                    </div>
                    <div class="as5-bottom2">
                        <img src="{{ asset('new-assets/assets/images/aboutUs/right-arrow.svg') }}" alt="">
                    </div>
                </div>
            </div>
         </section>
         <!-- Section 5 endss -->
        

        <!-- Section 6 starts -->
         @include('components.imran-components.as6')
        <!-- Section 6 ends -->

         @section("js")
<script src="{{ asset('/new-assets/js/home.js') }}"></script>
@endsection
@endsection