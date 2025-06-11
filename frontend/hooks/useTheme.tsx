import { createContext, type ReactNode, useContext, useState } from "react";

const ThemeContext = createContext({
  theme: "light",
  toggleTheme: () => {}
});

export function ThemeContextProvider({ children }: { children: ReactNode }) {
  const [theme, setTheme] = useState("light");

  const toggleTheme = () => {
    setTheme(theme === "light" ? "dark" : "light");
    console.log("clicked", theme);
  };

  return (
    <ThemeContext.Provider
      value={{
        theme,
        toggleTheme
      }}
    >
      {children}
    </ThemeContext.Provider>
  );
}

export function useTheme(): {
  isDark: boolean;
  theme: string;
  toggleTheme: () => void;
} {
  const { theme, toggleTheme } = useContext(ThemeContext);
  return {
    isDark: theme === "dark",
    theme,
    toggleTheme
  };
}
