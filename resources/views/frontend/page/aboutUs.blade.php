@extends('frontend.layouts.app')

@section('main-content')
<section class="about">
    <div class="container">
        <!-- Section 1 -->
        <div class="about-content d-flex flex-column flex-md-row align-items-start mb-4">
            <article class="about-text flex-2">
                <h3>About Us</h3>
                <p><strong>Shop Local, Support Human Stories, Encourage Sustainability!</strong></p>
            </article>
        </div>

        <!-- Section 2 -->
        <div class="about-content d-flex flex-column flex-md-row align-items-start mb-4">
            <article class="about-text flex-2">
                <h4>About Woich</h4>
                <p>Woich is India’s first marketplace for unique and creative products and services offered by local homegrown businesses and individuals in food and lifestyle categories. It’s home to a universe of special, trustworthy, extraordinary items, from unique handcrafted pieces to healthy food items and tailor-made services, all from the comfort of your home. Let’s embrace the charm of homegrown businesses.</p>
                <p>In an era dominated by technology, it’s our mission to keep local connections and sustainability at the heart of commerce. We’ve built a platform where trust can thrive, powered by people. We assist our community of sellers in turning their ideas into successful businesses. Our platform connects them with a vast base of buyers who seek something special with a human touch—products and services that offer imagination, care, and trust, all while maintaining convenience.</p>
            </article>
            <div class="about-image flex-1">
                <img src="http://127.0.0.1:8000/images/seeder/settings/logo.png" alt="About Woich" class="img-fluid">
            </div>
        </div>

        <!-- Section 3 -->
        <div class="about-content d-flex flex-column flex-md-row align-items-start mb-4">
            <div class="about-image flex-1">
                <img src="https://655452.github.io/Images/Register_page.png" alt="About Woich" class="img-fluid">
            </div>
            <article class="about-text flex-2">
                <h4>How Woich Works</h4>
                <p>Our marketplace is a vibrant community of homegrown businesses connecting with consumers over special goods and services. The platform empowers sellers to pursue their passions while helping buyers discover what they love.</p>
                <h4>Become a Woicher & Sell Extraordinary</h4>
                <p>We empower creative entrepreneurs to scale their businesses by offering a versatile platform, access to powerful tools, training, and dedicated support. Want to become a Woicher? Starting your journey is easy—just click the button below!</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
            </article>
        </div>

        <!-- Section 4 -->
        <div class="about-content d-flex flex-column flex-md-row align-items-start mb-4">
            <article class="about-text flex-2">
                <h4>Sign Up & Buy Extraordinary</h4>
                <p>From unique to personalized, our search tools help buyers explore one-of-a-kind items and services offered by our Woichers—all from the comfort of home. Our specially curated collections showcase relevant trends for every occasion, from everyday life to festive celebrations.</p>
                <h4>About the Founder</h4>
                <p>Mugdha Khandekar, founder of Woich (Maasa Ventures LLP), is a seasoned product leader with over 18 years of experience in retail technology. Previously, she served as Director at Myntra Designs (a Flipkart group company) and was part of the co-founding team at Pretr Technologies Pvt Ltd, which was acqui-hired by Myntra.</p>
                <p>As a mother of two, Mugdha’s passion for unique, handcrafted, and premium homegrown products inspired her to create Woich. Leveraging her expertise in supply chain, customer service, and B2C domains, she connects local businesses with a vast consumer base, empowering them to thrive.</p>
            </article>
            <div class="about-image flex-1">
                <img src="https://woich.in/frontend/main_banner/mockup.png" alt="About Woich" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<style>
    .about-content {
        gap: 20px;
        margin-top: 20px;
        background: linear-gradient(to bottom right, #f8f9fa, #e9ecef); /* Light gradient */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .about-image img {
        width: 100%;
        border-radius: 12px; /* Slightly more rounded corners for a modern look */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Image shadow for depth */
    }

    h3, h4 {
        color: #333;
        font-weight: bold;
        text-transform: uppercase; /* Bold and uppercase for headings */
    }

    p {
        line-height: 1.8; /* Increased line height for better readability */
        color: #555;
        font-size: 1.1rem; /* Slightly larger font for body text */
        margin-bottom: 15px;
    }

    .btn {
        margin-top: 15px;
        background-color: #5cb85c;
        border: none;
        padding: 10px 20px;
        border-radius: 30px; /* Rounded button for a friendly feel */
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #4cae4c; /* Darker shade on hover */
    }

    @media (max-width: 768px) {
        .about-content {
            flex-direction: column;
        }

        .about-image {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .about-text {
            text-align: center; /* Center-align text on mobile */
        }

        .about-content img {
            margin: 0 auto; /* Center the image on mobile */
        }

        .btn {
            width: 100%; /* Full-width button on mobile */
        }
    }
</style>
@endsection
