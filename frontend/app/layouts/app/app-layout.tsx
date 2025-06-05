import { Outlet } from "react-router";
import AppFooterLayout from "./app-footer-layout";
import AppHeaderLayout from "./app-header-layout";

function AppLayout() {
  return (
    <>
      <AppHeaderLayout />
      <Outlet />
      <AppFooterLayout />
    </>
  );
}

export default AppLayout;
