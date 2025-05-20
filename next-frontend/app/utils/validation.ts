export const validateEmail = (email: string): boolean => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
};

export const validatePassword = (password: string): boolean => {
  // At least 8 characters, 1 uppercase, 1 lowercase, 1 number
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  return passwordRegex.test(password);
};

export const validateName = (name: string): boolean => {
  return name.length >= 2 && name.length <= 50;
};

export const getPasswordStrength = (
  password: string
): "weak" | "medium" | "strong" => {
  if (password.length < 8) return "weak";

  const hasUpperCase = /[A-Z]/.test(password);
  const hasLowerCase = /[a-z]/.test(password);
  const hasNumbers = /\d/.test(password);
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

  const strength = [
    hasUpperCase,
    hasLowerCase,
    hasNumbers,
    hasSpecialChar,
  ].filter(Boolean).length;

  if (strength <= 2) return "weak";
  if (strength === 3) return "medium";
  return "strong";
};

export const getValidationError = (field: string, value: string): string => {
  switch (field) {
    case "email":
      if (!value) return "Email is required";
      if (!validateEmail(value)) return "Please enter a valid email address";
      break;
    case "password":
      if (!value) return "Password is required";
      if (!validatePassword(value))
        return "Password must be at least 8 characters with 1 uppercase, 1 lowercase, and 1 number";
      break;
    case "name":
      if (!value) return "Name is required";
      if (!validateName(value))
        return "Name must be between 2 and 50 characters";
      break;
    case "confirmPassword":
      if (!value) return "Please confirm your password";
      break;
  }
  return "";
};
