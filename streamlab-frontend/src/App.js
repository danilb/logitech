import { createBrowserRouter, RouterProvider } from "react-router-dom";
import LoginPage from "./pages/LoginPage";
import UserPage from "./pages/UserPage";

const router = createBrowserRouter([
    {path: '/', element: <LoginPage />},
    {path: '/userPage', element : <UserPage />}
]);

function App() {
    return <RouterProvider router={router} />;
}

export default App;
