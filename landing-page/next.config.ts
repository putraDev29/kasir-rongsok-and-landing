import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  // Support standalone build for cPanel Node.js App or export mode
  output: process.env.NEXT_OUTPUT_MODE === "export" ? "export" : "standalone",
  images: {
    // Enable unoptimized to ensure compatibility with standard cPanel hosting without requiring Sharp binaries
    unoptimized: true,
    remotePatterns: [
      { protocol: "https", hostname: "**" },
      { protocol: "http", hostname: "**" },
    ],
  },
  turbopack: {
    rules: {
      "*.css": {
        loaders: ["@tailwindcss/turbopack"],
        as: "*.css",
      },
    },
  },
};

export default nextConfig;
