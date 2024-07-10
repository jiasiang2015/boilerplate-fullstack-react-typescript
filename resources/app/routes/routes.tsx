import { Route, createRoutesFromElements } from "react-router-dom";

// 頁面
import EntryPage from "@/pages/EntryPage";


const appRoutes = createRoutesFromElements(
  <Route path="/">
    {/* ======================================================================================== */}
    {/* 前台 區域 */}
    <Route path="/" element={<EntryPage />} />
  </Route>
);

export default appRoutes;
