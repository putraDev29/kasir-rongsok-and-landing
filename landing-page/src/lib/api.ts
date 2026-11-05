const API_BASE_URL = process.env.NEXT_PUBLIC_API_BASE_URL || "http://localhost:8000";

export async function fetchApi<T>(endpoint: string, options?: RequestInit): Promise<T> {
  const url = `${API_BASE_URL.replace(/\/+$/, "")}/${endpoint.replace(/^\/+/, "")}`;

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

