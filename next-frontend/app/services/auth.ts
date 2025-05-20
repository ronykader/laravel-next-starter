import { AxiosError } from "axios";
import Cookies from "js-cookie";
import api from "./api";

interface LoginCredentials {
  email: string;
  password: string;
}

interface RegisterData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

interface ResetPasswordData {
  email: string;
}

interface NewPasswordData {
  email: string;
  token: string;
  password: string;
  password_confirmation: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  created_at: string;
  updated_at: string;
}

interface ApiResponse<T> {
  data: T;
  message?: string;
  errors?: Record<string, string[]>;
}

class AuthService {
  private readonly cookieName: string;
  private readonly cookieOptions: Cookies.CookieAttributes;

  constructor() {
    this.cookieName = process.env.NEXT_PUBLIC_AUTH_COOKIE_NAME || "auth_token";
    this.cookieOptions = {
      domain: process.env.NEXT_PUBLIC_AUTH_COOKIE_DOMAIN,
      secure: process.env.NEXT_PUBLIC_AUTH_COOKIE_SECURE === "true",
      sameSite: process.env.NEXT_PUBLIC_AUTH_COOKIE_SAME_SITE as
        | "strict"
        | "lax"
        | "none",
    };
  }

  async login(credentials: LoginCredentials): Promise<User> {
    try {
      const response = await api.post<ApiResponse<User>>("/login", credentials);
      return response.data.data;
    } catch (error) {
      if (error.response?.data?.errors) {
        throw new Error(
          Object.values(error.response.data.errors).flat().join(", ")
        );
      }
      throw new Error("Failed to login. Please try again.");
    }
  }

  async register(data: RegisterData): Promise<User> {
    try {
      const response = await api.post<ApiResponse<User>>("/register", data);
      return response.data.data;
    } catch (error) {
      if (error.response?.data?.errors) {
        throw new Error(
          Object.values(error.response.data.errors).flat().join(", ")
        );
      }
      throw new Error("Failed to register. Please try again.");
    }
  }

  async forgotPassword(data: ResetPasswordData): Promise<void> {
    try {
      await api.post<ApiResponse<void>>("/forgot-password", data);
    } catch (error) {
      if (error.response?.data?.errors) {
        throw new Error(
          Object.values(error.response.data.errors).flat().join(", ")
        );
      }
      throw new Error("Failed to send reset password email. Please try again.");
    }
  }

  async resetPassword(data: NewPasswordData): Promise<void> {
    try {
      await api.post<ApiResponse<void>>("/reset-password", data);
    } catch (error) {
      if (error.response?.data?.errors) {
        throw new Error(
          Object.values(error.response.data.errors).flat().join(", ")
        );
      }
      throw new Error("Failed to reset password. Please try again.");
    }
  }

  async logout(): Promise<void> {
    try {
      await api.post<ApiResponse<void>>("/logout");
      Cookies.remove(this.cookieName, this.cookieOptions);
    } catch (error) {
      // Even if the API call fails, we should still clear the cookie
      Cookies.remove(this.cookieName, this.cookieOptions);
      throw new Error("Failed to logout. Please try again.");
    }
  }

  async getCurrentUser(): Promise<User | null> {
    try {
      const response = await api.get<ApiResponse<User>>("/user");
      return response.data.data;
    } catch (error: unknown) {
      if (error instanceof AxiosError && error.response?.status !== 401) {
        console.error("Failed to get current user:", error.message);
      }
      return null;
    }
  }

  isAuthenticated(): boolean {
    return !!Cookies.get(this.cookieName);
  }
}

export const authService = new AuthService();
