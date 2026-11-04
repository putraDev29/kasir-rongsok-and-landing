"use client";

import React from "react";
import { motion } from "framer-motion";
import { MessageCircle, ArrowRight, ShieldCheck, Scale, Truck, MapPin, ChevronDown } from "lucide-react";
import Image from "next/image";
import { HeroData, LandingSettings, StatisticItem } from "@/types/landing-page";

interface HeroSectionProps {
  hero: HeroData;
  settings: LandingSettings;
  statistics: StatisticItem[];
}

export default function HeroSection({ hero, settings }: HeroSectionProps) {
  const handleScrollToCategories = (e: React.MouseEvent) => {
    e.preventDefault();
    const el = document.querySelector("#categories");
    if (el) el.scrollIntoView({ behavior: "smooth" });
  };

  const handleScrollToAbout = (e: React.MouseEvent) => {
    e.preventDefault();
    const el = document.querySelector("#about");
    if (el) el.scrollIntoView({ behavior: "smooth" });
  };

  return (
    <section
      id="hero"
      className="relative w-full h-[100dvh] max-h-[100dvh] flex flex-col justify-between pt-16 sm:pt-20 pb-2 sm:pb-3 overflow-hidden bg-gradient-to-b from-sky-50/70 via-white to-slate-50"
    >
      {/* Subtle ambient lighting */}
      <div className="absolute top-10 left-1/3 w-96 h-96 bg-sky-200/30 rounded-full blur-[140px] pointer-events-none" />
      <div className="absolute top-20 right-10 w-80 h-80 bg-blue-200/25 rounded-full blur-[130px] pointer-events-none" />

      <div className="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 w-full h-full flex flex-col justify-between gap-2 sm:gap-3 relative z-10">
        {/* 1. Header Bar: Headline, Tagline & CTAs */}
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="flex flex-col md:flex-row md:items-center justify-between gap-2 sm:gap-3 shrink-0 pt-0.5 sm:pt-1"
        >
          {/* Headline & Concise Subtitle */}
          <div className="space-y-0.5 sm:space-y-1">
            <div className="inline-flex items-center gap-1.5 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full bg-sky-100/90 border border-sky-200 text-sky-800 text-[10px] sm:text-[11px] font-bold tracking-wide">
              <span className="w-1.5 h-1.5 rounded-full bg-sky-600 animate-pulse" />
              <span>{settings.company_name} • Seberaya Logam</span>
            </div>

            <h1 className="text-lg sm:text-2xl md:text-3xl lg:text-[32px] font-extrabold text-slate-900 tracking-tight leading-snug">
              Pusat Jual Beli Besi Tua, Scrap Logam & Bongkaran
            </h1>

            <p className="text-[11px] sm:text-xs md:text-sm text-slate-600 font-normal leading-relaxed line-clamp-1 max-w-2xl">
              Menerima besi tua, tembaga, kuningan, aluminium, timah, nikel, tabung gas & bongkaran gedung. Timbangan digital presisi & pelunasan tunai di tempat.
            </p>
          </div>

          {/* Action Buttons */}
          <div className="flex items-center gap-2 shrink-0">
            <a
              href={settings.whatsapp_url}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-bold text-xs sm:text-sm shadow-md shadow-sky-500/25 transition-all hover:scale-105 active:scale-95"
            >
              <MessageCircle className="w-3.5 sm:w-4 h-3.5 sm:h-4 fill-white" />
              <span>Chat WhatsApp</span>
            </a>

            <button
              onClick={handleScrollToCategories}
              className="inline-flex items-center gap-1 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl bg-white hover:bg-sky-50 text-slate-700 hover:text-sky-700 font-semibold text-xs sm:text-sm border border-slate-200 shadow-xs transition-all"
            >
              <span>Cek Harga</span>
              <ArrowRight className="w-3 sm:w-3.5 h-3 sm:h-3.5 text-sky-600" />
            </button>
          </div>
        </motion.div>

        {/* 2. POWERFUL VISUAL SHOWCASE GRID (Dynamically fills all remaining vertical space on any device) */}
        <motion.div
          initial={{ opacity: 0, scale: 0.98 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.6, delay: 0.1 }}
          className="flex-1 min-h-0 w-full flex flex-col md:grid md:grid-cols-12 gap-2 sm:gap-3.5"
        >
          {/* Main Hero Photo (Fills dynamically on mobile, 7 cols on desktop) */}
          <div className="md:col-span-7 flex-1 min-h-0 md:h-full relative rounded-2xl md:rounded-3xl overflow-hidden shadow-md border border-sky-100 group">
            <Image
              src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1200&auto=format&fit=crop"
              alt="Gudang Scrap Besi Tua & Logam"
              fill
              priority
              className="object-cover group-hover:scale-105 transition-transform duration-700"
              sizes="(max-width: 768px) 100vw, 60vw"
            />
            {/* Visual overlay gradient */}
            <div className="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent" />

            {/* Floating Top Badge */}
            <div className="absolute top-2.5 left-2.5 sm:top-4 sm:left-4 flex items-center gap-2">
              <span className="px-2.5 py-1 rounded-full bg-white/95 text-sky-900 text-[10px] sm:text-[11px] font-bold shadow-md backdrop-blur-md border border-sky-200 flex items-center gap-1.5">
                <span className="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-500 animate-ping" />
                Operasional 24 Jam
              </span>
            </div>

            {/* Bottom Caption on Photo */}
            <div className="absolute bottom-2.5 left-2.5 right-2.5 sm:bottom-4 sm:left-4 sm:right-4 flex items-end justify-between">
              <div className="text-white space-y-0.5">
                <span className="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-sky-300">Depo Srengseng Sawah • Jagakarsa</span>
                <h3 className="text-xs sm:text-base font-bold text-white leading-snug">Penimbangan Digital & Penampungan Logam Scrap</h3>
                <p className="text-[11px] text-slate-200 hidden sm:block line-clamp-1">Fasilitas timbangan digital akurat di Jakarta Selatan, siap tampung partai kecil & besar.</p>
              </div>

              <a
                href={settings.whatsapp_url}
                target="_blank"
                rel="noopener noreferrer"
                className="shrink-0 p-1.5 sm:p-2.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white shadow-lg transition-transform hover:scale-110 ml-2"
                title="Hubungi Admin WhatsApp"
              >
                <ArrowRight className="w-3.5 sm:w-4 h-3.5 sm:h-4" />
              </a>
            </div>
          </div>

          {/* Secondary Visual Cards (5 Columns on desktop, 3 columns on mobile) */}
          <div className="md:col-span-5 grid grid-cols-3 md:grid-cols-1 gap-1.5 sm:gap-2.5 h-[62px] sm:h-[76px] md:h-full shrink-0 md:shrink">
            {/* Card 1: Scrap Tembaga & Kuningan */}
            <div className="relative h-full min-h-0 rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-sky-100 group">
              <Image
                src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?q=80&w=800&auto=format&fit=crop"
                alt="Scrap Tembaga & Logam Non-Besi"
                fill
                className="object-cover group-hover:scale-105 transition-transform duration-500"
                sizes="(max-width: 768px) 33vw, 40vw"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent" />
              <div className="absolute bottom-1.5 left-2 right-2 text-white">
                <span className="text-[7.5px] sm:text-[9px] text-amber-300 font-bold uppercase tracking-wider block">Logam Presisi</span>
                <h4 className="text-[9.5px] sm:text-xs md:text-sm font-bold text-white leading-tight line-clamp-1">Tembaga, Kuningan & Nikel</h4>
              </div>
            </div>

            {/* Card 2: Armada Penjemputan Truk / Pick-Up */}
            <div className="relative h-full min-h-0 rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-sky-100 group">
              <Image
                src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?q=80&w=800&auto=format&fit=crop"
                alt="Armada Penjemputan Truk Rongsokan"
                fill
                className="object-cover group-hover:scale-105 transition-transform duration-500"
                sizes="(max-width: 768px) 33vw, 40vw"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent" />
              <div className="absolute bottom-1.5 left-2 right-2 text-white">
                <span className="text-[7.5px] sm:text-[9px] text-sky-300 font-bold uppercase tracking-wider block">Armada Jemput</span>
                <h4 className="text-[9.5px] sm:text-xs md:text-sm font-bold text-white leading-tight line-clamp-1">Truk & Pick-Up Siap 24 Jam</h4>
              </div>
            </div>

            {/* Card 3: Bongkaran Bangunan & Tabung Gas */}
            <div className="relative h-full min-h-0 rounded-xl sm:rounded-2xl overflow-hidden shadow-xs border border-sky-100 group">
              <Image
                src="https://images.unsplash.com/photo-1526951521990-620dc14c214b?q=80&w=800&auto=format&fit=crop"
                alt="Bongkaran Bangunan & Tabung Gas"
                fill
                className="object-cover group-hover:scale-105 transition-transform duration-500"
                sizes="(max-width: 768px) 33vw, 40vw"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent" />
              <div className="absolute bottom-1.5 left-2 right-2 text-white">
                <span className="text-[7.5px] sm:text-[9px] text-teal-300 font-bold uppercase tracking-wider block">Bongkar & Gas</span>
                <h4 className="text-[9.5px] sm:text-xs md:text-sm font-bold text-white leading-tight line-clamp-1">Bongkar Gedung & Tabung Gas</h4>
              </div>
            </div>
          </div>
        </motion.div>

        {/* 3. Bottom Row: Quick Trust Badges & Subtle Scroll Cue */}
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5, delay: 0.15 }}
          className="shrink-0 space-y-1 sm:space-y-1.5"
        >
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-1.5 sm:gap-2 text-xs">
            <div className="flex items-center gap-1.5 sm:gap-2 bg-white/90 backdrop-blur-sm border border-sky-100 px-2.5 py-1.5 sm:py-2 rounded-xl shadow-2xs">
              <Scale className="w-3.5 h-3.5 text-sky-600 shrink-0" />
              <span className="font-semibold text-slate-800 text-[10px] sm:text-[11px] truncate">Timbangan Digital Presisi</span>
            </div>
            <div className="flex items-center gap-1.5 sm:gap-2 bg-white/90 backdrop-blur-sm border border-sky-100 px-2.5 py-1.5 sm:py-2 rounded-xl shadow-2xs">
              <Truck className="w-3.5 h-3.5 text-sky-600 shrink-0" />
              <span className="font-semibold text-slate-800 text-[10px] sm:text-[11px] truncate">Armada Jemput 24 Jam</span>
            </div>
            <div className="flex items-center gap-1.5 sm:gap-2 bg-white/90 backdrop-blur-sm border border-sky-100 px-2.5 py-1.5 sm:py-2 rounded-xl shadow-2xs">
              <ShieldCheck className="w-3.5 h-3.5 text-sky-600 shrink-0" />
              <span className="font-semibold text-slate-800 text-[10px] sm:text-[11px] truncate">Bayar Kontan di Tempat</span>
            </div>
            <div className="flex items-center gap-1.5 sm:gap-2 bg-white/90 backdrop-blur-sm border border-sky-100 px-2.5 py-1.5 sm:py-2 rounded-xl shadow-2xs">
              <MapPin className="w-3.5 h-3.5 text-sky-600 shrink-0" />
              <span className="font-semibold text-slate-800 text-[10px] sm:text-[11px] truncate">Jagakarsa, Jakarta Selatan</span>
            </div>
          </div>

          {/* Centered Scroll Indicator */}
          <div className="flex justify-center items-center">
            <button
              onClick={handleScrollToAbout}
              className="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-semibold text-slate-400 hover:text-sky-600 transition-colors group cursor-pointer"
            >
              <span>Scroll untuk daftar harga & profil</span>
              <ChevronDown className="w-3 h-3 text-sky-500 animate-bounce group-hover:translate-y-0.5 transition-transform" />
            </button>
          </div>
        </motion.div>
      </div>
    </section>
  );
}
