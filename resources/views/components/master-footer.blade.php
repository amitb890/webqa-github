<footer class="genarel_footer_area {{ \Route::current() && \Route::current()->getName() == 'analysis' ? 'd-none' : '' }}">

    <div class="container-fluid">
    <div class="g_footer_main">
        <div class="single_footer_item footer-fast-item">
        <img src="/new-assets/assets/images/webQA_logo.png" alt="icon">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        <div class="footer_social">
            <ul>
            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
            <li><a href="#"><img src="/new-assets/assets/images/youtube.png" alt="icon"> </a></li>
            </ul>
        </div>
        </div>
        <div class="single_footer_item">
        <div class="footer_list_items">
            <ul>
            <li><a href="#">About Us</a></li>
            <li><a href="#">7 Day Free Trial</a></li>
            <li><a href="#">Tools</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        </div>
        <div class="single_footer_item">
        <div class="footer_list_items">
            <ul>
            <li><a href="#">Login</a></li>
            <li><a href="#">FAQ’s</a></li>
            <li><a data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">Privacy Policy</a></li>
            <li><a  data-bs-toggle="modal" data-bs-target="#termsOfUseModal">Terms of Use</a></li>
            </ul>
        </div>
        </div>
        <div class="footer_search_item footer-form-container">
        <h5>Test Your Website’s Performance for Free!</h5>
        <form class="footer_search_box" id="footer_search_box_home">
            <input
            id="urlValueFooter"
            type="text"
            class="footer_control"
            name="search"
            placeholder="Enter your website url.."
            />
            <div class="footer_utils">
            <a id="startTestFooter" class="btn btn_primary rounded-pill">Test Now</a>
            </div>
        </form>
        </div>
    </div>
    <div class="copy_right_area">
        <p>© WebQA 2022 | All rights reserved</p>
    </div>
    </div>
</footer>
<!-- Footer Area End -->