import React from "react";
import { getLandingPageData } from "@/services/landing-page.service";
import Navbar from "@/components/layout/Navbar";
import Footer from "@/components/layout/Footer";
import WhatsAppButton from "@/components/layout/WhatsAppButton";
import HeroSection from "@/components/sections/HeroSection";
import AboutSection from "@/components/sections/AboutSection";
import ServicesSection from "@/components/sections/ServicesSection";
import CategoriesSection from "@/components/sections/CategoriesSection";
import WhyChooseUsSection from "@/components/sections/WhyChooseUsSection";
import ProcessSection from "@/components/sections/ProcessSection";
import GallerySection from "@/components/sections/GallerySection";
import StatisticsSection from "@/components/sections/StatisticsSection";
import LocationSection from "@/components/sections/LocationSection";
import TestimonialsSection from "@/components/sections/TestimonialsSection";
import FAQSection from "@/components/sections/FAQSection";
import ContactSection from "@/components/sections/ContactSection";

export default async function HomePage() {
  const data = await getLandingPageData();

  return (
    <div className="min-h-screen bg-white text-slate-800 flex flex-col overflow-x-hidden selection:bg-sky-500 selection:text-white">
      {/* Dynamic Sticky Header */}
      <Navbar settings={data.settings} />

      {/* Main Content Sections */}
      <main className="flex-1">
        {/* A. Hero Section */}
        <HeroSection
          hero={data.hero}
          settings={data.settings}
          statistics={data.statistics}
        />

        {/* B. About Us */}
        <AboutSection
          about={data.about}
          settings={data.settings}
        />

        {/* C. Services */}
        <ServicesSection
          services={data.services}
          settings={data.settings}
        />

        {/* D. Scrap Categories & Live Prices */}
        <CategoriesSection
          categories={data.categories}
          settings={data.settings}
        />

        {/* E. Why Choose Us */}
        <WhyChooseUsSection
          items={data.why_choose_us}
          settings={data.settings}
        />

        {/* F. Business Process / Workflow */}
        <ProcessSection
          steps={data.process}
          settings={data.settings}
        />

        {/* G. Operations Gallery with Lightbox */}
        <GallerySection
          gallery={data.gallery}
        />

        {/* H. Animated Counter Statistics */}
        <StatisticsSection
          statistics={data.statistics}
        />

        {/* I. Google Maps Location */}
        <LocationSection
          location={data.location}
          settings={data.settings}
        />

        {/* J. Testimonials */}
        <TestimonialsSection
          testimonials={data.testimonials}
        />

        {/* K. FAQ Accordion */}
        <FAQSection
          faqs={data.faqs}
          settings={data.settings}
        />

        {/* L. Contact & Inquiry Form */}
        <ContactSection
          settings={data.settings}
        />
      </main>

      {/* Modern Dynamic Footer */}
      <Footer
        settings={data.settings}
        categories={data.categories}
      />

      {/* WhatsApp Floating Action Button */}
      <WhatsAppButton
        settings={data.settings}
      />
    </div>
  );
}
