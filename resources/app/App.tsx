import { useEffect } from 'react'
import { RouterProvider, createBrowserRouter } from 'react-router-dom'
import appRoutes from './routes/routes';

import './App.scss'


function App() {
  useEffect(() => {
    window.scrollTo(0, 1);
  }, []);

  return (
    <RouterProvider router={createBrowserRouter(appRoutes)} />
  )
}

export default App
