<?php
// contactPage.php
?>

<style>
    .contact-hero {
        background: linear-gradient(135deg, #231f20 0%, #3a3a3a 100%);
        padding: 4rem 0;
        position: relative;
    }

    .hero-title {
        font-family: 'Oswald', sans-serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: #e0e0e0;
        margin-bottom: 2rem;
    }

    .contact-cards {
        margin-top: -2rem;
        position: relative;
        z-index: 3;
    }

    .contact-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        height: 100%;
    }

    .contact-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .contact-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4267B2, #365899);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
    }

    .facebook-btn {
        background: linear-gradient(135deg, #4267B2, #365899);
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .facebook-btn:hover {
        background: linear-gradient(135deg, #365899, #2d4373);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .info-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #231f20, #3a3a3a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .info-text {
        margin: 0;
        font-weight: 500;
        color: #333;
    }

    .section-title {
        font-family: 'Oswald', sans-serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: #231f20;
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #4267B2, #365899);
        border-radius: 2px;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #231f20, #3a3a3a);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .contact-card {
            padding: 2rem;
            margin-bottom: 2rem;
        }
    }
</style>

<div class="contact-hero">
    <div class="container">
        <div class="text-center">
            <h1 class="hero-title">GET IN TOUCH</h1>
            <p class="hero-subtitle">Connect with Weltz Industrial Philippines Inc.</p>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row contact-cards">
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="contact-card">
                <div class="text-center">
                    <div class="contact-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <h3 class="mb-4" style="font-family: 'Oswald', sans-serif; color: #231f20;">Connect With Us on Facebook</h3>
                    <p class="mb-4 text-muted" style="font-size: 1.1rem;">
                        Stay updated with our latest products, services, and company news. Follow us on Facebook for real-time updates and connect with our community.
                    </p>
                    <a href="https://www.facebook.com/WeltzIndustrialPhilippines" target="_blank" class="facebook-btn">
                        <i class="fab fa-facebook-f"></i>
                        Visit Our Facebook Page
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="contact-card">
                <h4 class="mb-4 text-center" style="font-family: 'Oswald', sans-serif; color: #231f20;">Contact Information</h4>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <p class="info-text">WELTZPHILS@GMAIL.COM</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <p class="info-text">CAINTA, RIZAL</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fab fa-facebook-messenger"></i>
                    </div>
                    <div>
                        <p class="info-text">Facebook Messenger</p>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        <i class="fas fa-clock"></i>
                        We're here to help you with all your industrial needs.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h2 class="section-title">Why Choose Weltz Industrial?</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="contact-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h5 style="font-family: 'Oswald', sans-serif; color: #231f20;">Quality Products</h5>
                <p class="text-muted">Premium industrial equipment and supplies for your business needs.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="contact-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h5 style="font-family: 'Oswald', sans-serif; color: #231f20;">Expert Support</h5>
                <p class="text-muted">Professional assistance and guidance from our experienced team.</p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="contact-card text-center">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h5 style="font-family: 'Oswald', sans-serif; color: #231f20;">Fast Delivery</h5>
                <p class="text-muted">Quick and reliable delivery service across the Philippines.</p>
            </div>
        </div>
    </div>
</div>