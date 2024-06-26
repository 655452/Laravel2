<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use App\Models\User;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::insert([
            [
                'title'                  => 'Terms & Conditions',
                'slug'                   => 'terms-and-condition',
                'description'            => 'PLEASE READ THESE TERMS OF USE (“TERMS”) CAREFULLY BEFORE USING ANY FoodBank PLATFORM.



                If you live in any of the following countries or regions, additional terms may apply to you and are viewable at the bottom of these Terms. We display the country/region within the Terms when applicable. These additional terms override the Terms below to the extent of any inconsistency.



                Argentina, Australia, Brazil, Canada, Colombia, Hong Kong, Japan, Korea, Philippines, all European countries (including specific terms for Austria, Belgium, France, Germany, Hungary, Italy, Poland and Switzerland.



                Welcome to the FoodBank community! You are reading these Terms because you are using a FoodBank website, digital experience, social media platform, mobile app, wearable technology, or one of our other products or services, all of which are part of FoodBanks Platform (“Platform”). You may access the Platform through a computer, mobile phone, tablet, console or other technology, which we refer to here as a “Device”. Your service provider’s normal rates and fees apply to your Device.



                These Terms create a legally binding agreement between you and FoodBank and its affiliates regarding your use of the Platform. Please review our List of Local Entities for the name of the FoodBank entity responsible for providing the Platform to you and the appropriate contact information. A few important points:



                Our Terms May Change. Some jurisdictions do not permit unilateral updates or changes to consumer terms, so this paragraph may not apply to you. We may update these Terms from time to time. If a material change is made, we will post a notice on the Platform or send you a notification. Read through any changes, and if you donot agree to them, please stop using the Platform. If you continue to use our Platform after we notify you of changes, you will be deemed to have accepted the updated Terms, except to the extent prohibited by applicable law.

                Terms of Sale. By making any purchase with us, you also agree to the Terms of Sale that apply in your country or region.

                Privacy Policy. Our Privacy Policy describes the collection and use of personal information on the Platform and applies to your use of the Platform.

                Important Notice for Amateur Athletes. You are responsible for ensuring that your participation on the Platform does not affect your eligibility as an amateur athlete. Please check with your amateur athletic association for the rules that apply to you. Shopprz is not responsible or liable for your use of the Platform resulting in your ineligibility as an amateur athlete.',
                'footer_menu_section_id' => 1,
                'template_id'            => 1,
                'creator_type'           => User::class,
                'editor_type'            => User::class,
                'creator_id'             => 1,
                'editor_id'              => 1,
            ],
            [
                'title'                  => 'About US',
                'slug'                   => 'about-us',
                'description'            => "Welcome to Foodbank, your ultimate destination for delicious meals delivered right to your doorstep. At Foodbank, we believe that everyone deserves access to fresh, wholesome food, conveniently and affordably.

                As a multivendor food delivery platform, we bring together a diverse array of culinary talents, local eateries, and passionate chefs under one virtual roof. Our mission is simple: to connect food lovers with the best culinary experiences while supporting local businesses and communities.

                What sets Foodbank apart is our commitment to quality, variety, and convenience. Whether you're craving savory classics, international flavors, or healthy options, our platform offers an extensive selection to satisfy every palate and dietary preference. From gourmet delicacies to comforting home-cooked meals, our vendors craft each dish with care and expertise.

                At Foodbank, we prioritize transparency and trust. We partner with reputable vendors who share our dedication to using fresh, high-quality ingredients and adhering to strict hygiene standards. With our user-friendly interface and secure payment system, ordering your favorite meals is quick, easy, and reliable.

                Beyond providing delicious food, Foodbank is dedicated to making a positive impact in the communities we serve. We collaborate with local food banks and charitable organizations to address food insecurity and support initiatives that promote food sustainability and access for all.

                Join us on our journey to redefine food delivery. Whether you're a food enthusiast, a culinary entrepreneur, or someone looking for convenient meal solutions, Foodbank welcomes you to explore, indulge, and savor the flavors of our vibrant food community.

                Thank you for choosing Foodbank. Together, let's savor the joy of good food and shared experiences.",
                'footer_menu_section_id' => 2,
                'template_id'            => 2,
                'creator_type'           => User::class,
                'editor_type'            => User::class,
                'creator_id'             => 1,
                'editor_id'              => 1,
            ],
            [
                'title'                  => 'Privacy',
                'slug'                   => 'privacy',
                'description'            => 'This privacy policy describes the personal data collected or generated (processed) when you interact with FoodBank through our websites, digital experiences, mobile applications, stores, events, or one of our other products or services, all of which are part of FoodBank’s Platform (“Platform”). It also explains how your personal data is used, shared and protected, what choices you have relating to your personal data and how you can contact us.



                WHO is Responsible for the Processing of Your Personal Data?



                The FoodBank entity responsible for the processing of your personal data will depend on how you interact with FoodBank’s Platform and where you are located in the world.



                Please review our List of Local Entities for the name of the FoodBank entity responsible and the appropriate contact information.



                WHAT Personal Data Do We Collect and WHEN?



                We ask you for certain personal data to provide you with the products or services you request. For example, when you make purchases, contact our consumer services, request to receive communications, create an account, participate in our events or contests, or use our Platform. Additionally, when you request specific services in store, we may ask you to login to provide services that are then associated with your account (e.g. size, fit, preferences).



                This personal data includes your:



                - contact details including name, email, telephone number and shipping and billing address;

                - login and account information, including screen name, password and unique user ID;

                - personal details including gender, hometown, date of birth and purchase history;

                - payment or credit card information;

                - images, photos and videos;

                - data on physical characteristics, including weight, height, and body measurements (such as estimated stride and shoe/foot measurements or apparel size);

                - fitness activity data provided by you or generated through our Platform (time, duration, distance, location, calorie count, pace/stride); or

                - personal preferences including your wish list as well as marketing and cookie preferences.



                We collect additional personal data from you to enable particular features within our Platform. For example, we request access to your phone’s location data to log your run route, your contacts to allow you to interact with your friends, your calendar to schedule a training plan or your social network credentials to post content from our Platform to a social network. This personal data includes your:



                - movement data from your devices accelerometer;

                - photos, audio, contacts and calendar information;

                - sensor data, including heart rate and (GPS) location data; or

                - social network information, including credentials and any information from your public posts about Nike or your communications with us.



                When interacting with our Platform, certain data is automatically collected from your device or web browser. More information about these practices is included in the “Cookies and Pixel Tags” section of this privacy policy below. This data includes:



                - Device IDs and type, call state, network access, storage information and battery information;

                - Traffic data about your visit to and interactions with our Platform, including products you viewed, added to your cart or searched for and whether you are logged-in to your Nike account;

                - Cookies, IP addresses, referrer headers, data identifying your web browser and version, web beacons, tags and interactions with our Platform.',
                'footer_menu_section_id' => 2,
                'template_id'            => 2,
                'creator_type'           => User::class,
                'editor_type'            => User::class,
                'creator_id'             => 1,
                'editor_id'              => 1,
            ],
            [
                'title'                  => 'Contact Us',
                'slug'                   => 'contact-us',
                'description'            => 'Every day, more than 1000 guests visit FoodBank restaurants around the city. And they do so because our restaurants are known for serving high-quality, great-tasting, and affordable food. Our commitment to premium ingredients, signature recipes, and friendly dining experiences is what has defined our brand for more than 5 successful years.',
                'footer_menu_section_id' => 1,
                'template_id'            => 3,
                'creator_type'           => User::class,
                'editor_type'            => User::class,
                'creator_id'             => 1,
                'editor_id'              => 1,
            ],
        ]);
    }
}
