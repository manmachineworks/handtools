<!doctype html>
<html class="no-js" lang="zxx">
@include('layout/head')
<body>
    <!--********************************
   		Code Start From Here 
	******************************** -->

@include('layout/header')
<!-- ====================================== Section One ===================================== -->
<section class="section-one">
    <div class="page-img-header" id="conatct-bg">
        <div class="container">
            <h1 class="img-header-text fade_down">Contact Us</h1>
            <div class="breadcrumb-group fade_up">
                <a href="index.html">HOME / </a>
                <a href="contact.html">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<!-- ====================================== Section Eight ===================================== -->
<section class="section-eight">
    <div class="container">
        <div class="row">
            <div class="quality-main about-qulity-main fade_down">
                <p class="quality">CONTACT OUR TEAM</p>
            </div>

            <h2 class="handyman-text handyman-services project-page-heading fade_down">
                Reach Out & Connect with Gurunanak Hand Tools
            </h2>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <p class="fusce malesuada tellus fade_down mt-0">
                    Need help choosing the right tools, want bulk pricing, or looking for dealership support?
                    Share your requirements and our team will get back to you quickly with the best solution.
                </p>

                <div class="contact-head-main">

                    <!-- Call -->
                    <div class="head-phone-white-main contact-deatils-head">
                        <div class="headphone-white">
                            <img src="/assets/new_assets/images/svg/headphone-white.svg" alt="headphone-white">
                        </div>
                        <div>
                            <p class="CallUs">Call Us</p>
                            <a href="tel:+91XXXXXXXXXX" class="CallUs-phone">
                                <p>+91 XXXXXXXXXX</p>
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="head-phone-white-main contact-deatils-head">
                        <div class="headphone-white">
                            <img src="/assets/new_assets/images/svg/email-White.svg" alt="email-White">
                        </div>
                        <div>
                            <p class="CallUs">Email Us</p>
                            <a href="mailto:info@gurunanakhandtools.com" class="CallUs-phone">
                                <p>info@gurunanakhandtools.com</p>
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="head-phone-white-main contact-deatils-head">
                        <div class="headphone-white">
                            <img src="/assets/new_assets/images/svg/loaction-white.svg" alt="loaction-white">
                        </div>
                        <div>
                            <p class="CallUs">Find Us</p>
                            <p class="CallUs-phone">Your Address, City, State, India</p>
                        </div>
                    </div>

                </div>

                <!-- Social (replace links) -->
                <div class="home-media-icon-main-head" id="conat-media-icon-main-head">
                    <a href="#" aria-label="Facebook">
                        <div class="home-media-icon-main">
                            <img src="/assets/new_assets/images/svg/facebook.svg" alt="home-fb-icon">
                        </div>
                    </a>
                    <a href="#" aria-label="X">
                        <div class="home-media-icon-main">
                            <img src="/assets/new_assets/images/svg/twiiter.svg" alt="home-tw-icon">
                        </div>
                    </a>
                    <a href="#" aria-label="Instagram">
                        <div class="home-media-icon-main">
                            <img src="/assets/new_assets/images/svg/insta.svg" alt="home-insta-icon">
                        </div>
                    </a>
                    <a href="#" aria-label="LinkedIn">
                        <div class="home-media-icon-main">
                            <img src="/assets/new_assets/images/svg/linkdien.svg" alt="home-be-icon">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <form action="{{ route('contact.submit') }}"
                        method="POST"
                        class="search-box-main ajax-contact"
                        id="contact-page-form">

                        @csrf

                        <!-- Name -->
                        <div class="search-input">
                            <input type="text"
                                name="name"
                                placeholder="Your Name*"
                                required
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="search-input">
                            <input type="text"
                                name="phone"
                                placeholder="Your Phone Number*"
                                required
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="search-input">
                            <input type="email"
                                name="email"
                                placeholder="Your Email*"
                                required
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div class="search-input">
                            <input type="text"
                                name="subject"
                                placeholder="Enter your subject*"
                                required
                                value="{{ old('subject') }}">
                            @error('subject')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="search-input">
                            <textarea name="message"
                                    placeholder="Tell us what you need (Tools / Brand / Quantity / City)..."
                                    required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="Submit mb-0">
                            <button type="submit" class="btn-main btn2">
                                Send Enquiry
                                <span class="arrow-section">
                                    <img class="arrow"
                                        src="/assets/new_assets/images/svg/right-arrow-svg.svg"
                                        alt="right-arrow-svg">
                                </span>
                                <div class="btn-box-left btn2"></div>
                                <div class="btn-box-right btn2"></div>
                            </button>
                        </div>

                    </form>

            </div>

        </div>
    </div>
</section>

<!-- ====================================== Section Nine ===================================== -->
<section class="map-section">
    <h2 class="d-none">hidden</h2>
    <div class="curved-section">
        <!-- Replace with your Google Map embed -->
        <iframe class="map-iframe"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11661.278162829134!2d-76.16113884753138!3d43.0557465765357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d9f3add89232d3%3A0x516c4febad79a023!2sNear%20Northeast%2C%20Syracuse%2C%20NY%2013203%2C%20USA!5e0!3m2!1sen!2sin!4v1704092010021!5m2!1sen!2sin"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>

<!-- ====================================== Section REPAIR & INSTALLATION ===================================== -->
<section class="installation-section pt-0">
    <div class="container">
        <div class="row faq-sec-Row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 installation-img-group">
                <img class="installation-img1 img-animation-style4 reveal"
                    src="/assets/new_assets/images/home-page/installation-img1.jpg" alt="installation-img1">
                <img class="installation-img2 img-animation-style2 reveal"
                    src="/assets/new_assets/images/home-page/installation-img2.jpg" alt="installation-img2">

                <div class="yerOfExperi">
                    <h2>25+</h2>
                    <p>Years of Experience</p>
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">HELP & SUPPORT</p>
                </div>

                <h2 class="handyman-text fade_down">Frequently asked questions</h2>

                <p class="fusce fade_down">
                    Here are some common questions about ordering, delivery, brands, and product selection.
                    If you need quick help, contact our team anytime.
                </p>

                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Do you provide bulk orders for workshops and industries?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. We support bulk and repeat orders for workshops, contractors, fabrication units,
                                and industrial buyers. Share your list and quantity for the best pricing.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How can I choose the right tool or brand?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Tell us your application (fabrication, maintenance, electrical, mechanical, etc.).
                                We’ll recommend the right category, specs, and trusted brands based on your use.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What is your delivery and support process?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                After confirmation, we process the order quickly and coordinate dispatch based on your
                                location. Our team provides pre-sales and after-sales assistance for smooth fulfillment.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Do you deal in power tools, welding, and measuring instruments?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. We offer Hand Tools & Tool Kits, Power Tools & Machinery, Welding Machines &
                                Accessories, Measuring Instruments, Cutting & Abrasive Tools, and workshop essentials.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed mb-0" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Can I become a dealer or distributor?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. If you’re interested in dealership/distribution, contact us with your business details
                                and location. Our team will guide you through the process.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contaForm');
    const successMessage = document.getElementById('success-message');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(response => {
            if (response.ok) return response.json();
            return response.json().then(err => Promise.reject(err));
        })
        .then(data => {
            form.reset();
            successMessage.style.display = 'block';
            successMessage.innerText = 'Your message has been sent successfully!';
            
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            console.error('Submission error:', error);
        });
    });
});
</script>

    @include('layout/footer')
</body>

</html>