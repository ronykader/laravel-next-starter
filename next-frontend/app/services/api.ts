import axios from "axios";
import Cookies from "js-cookie";

const api = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
  withCredentials: true, // Important for cookies
});

// Request interceptor
api.interceptors.request.use(
  (config) => {
    // Cookies are automatically sent with requests when withCredentials is true
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Clear the auth cookie
      Cookies.remove(process.env.NEXT_PUBLIC_AUTH_COOKIE_NAME || "auth_token", {
        domain: process.env.NEXT_PUBLIC_AUTH_COOKIE_DOMAIN,
        secure: process.env.NEXT_PUBLIC_AUTH_COOKIE_SECURE === "true",
        sameSite: process.env.NEXT_PUBLIC_AUTH_COOKIE_SAME_SITE as
          | "strict"
          | "lax"
          | "none",
      });

      // Redirect to login page
      if (typeof window !== "undefined") {
        window.location.href = "/login";
      }
    }
    return Promise.reject(error);
  }
);

export default api;
