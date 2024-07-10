import { useNavigate } from "react-router-dom"

export function useAppNavigate() {
  const navigate = useNavigate();

  const navigateToEntry = () => {
    navigate('/');
  }

  return { navigateToEntry }
}