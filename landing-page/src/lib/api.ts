export function getApiBaseUrl(): string {
  if (typeof window !== "undefined") {
    // In client browser:
    // If NEXT_PUBLIC_API_BASE_URL is explicitly defined, use it.
    // Otherwise fallback to the current website domain origin.
    if (process.env.NEXT_PUBLIC_API_BASE_URL) {
      return process.env.NEXT_PUBLIC_API_BASE_URL.replace(/\/+$/, "");
    }
    return window.location.origin;
  }

  // On Server-side (Node.js SSR):
  return (
    process.env.INTERNAL_API_BASE_URL ||
    process.env.NEXT_PUBLIC_API_BASE_URL ||
    "http://127.0.0.1:8000"
  ).replace(/\/+$/, "");
}

export async function fetchApi<T>(endpoint: string, options?: RequestInit): Promise<T> {
  const baseUrl = getApiBaseUrl();
  const cleanEndpoint = endpoint.replace(/^\/+/, "");
  const url = `${baseUrl}/${cleanEndpoint}`;

  try {
    const res = await fetch(url, {
      ...options,
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
        Connection: "close",
        ...(options?.headers || {}),
      },
      // Always fetch fresh data so admin changes take effect immediately
      cache: "no-store",
    });

    if (!res.ok) {
      throw new Error(`API error ${res.status}: ${res.statusText}`);
    }

    const json = await res.json();
    return json;
  } catch (error) {
    console.warn(`[API Client Warning] Failed fetching from ${url}:`, error);
    throw error;
  }
}

