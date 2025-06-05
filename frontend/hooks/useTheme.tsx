import { createContext, useContext, useState } from "react";

const ThemeContext = createContext({
  theme: "light",
  toggleTheme: () => {}
});

export function ThemeContextProvider({
  children
}: {
  children: React.ReactNode;
}) {
  const [theme, setTheme] = useState("light");

  const toggleTheme = () => {
    setTheme(theme === "light" ? "dark" : "light");
    console.log("clicked");
  };

  return (
    <ThemeContext
      value={{
        theme,
        toggleTheme
      }}
    >
      {children}
    </ThemeContext>
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
