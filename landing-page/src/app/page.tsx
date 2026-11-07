import React from "react";
import { getLandingPageData } from "@/services/landing-page.service";
import LandingPageClient from "@/components/layout/LandingPageClient";

// Force dynamic server execution or instant hydration
export const dynamic = "force-dynamic";
export const revalidate = 0;

export default async function HomePage() {
  const initialData = await getLandingPageData();

  return <LandingPageClient initialData={initialData} />;
}
