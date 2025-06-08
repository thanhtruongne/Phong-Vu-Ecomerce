import { createContext, useContext, useEffect, useState } from "react";
import { useSelector } from "react-redux";
import { useLocation } from "react-router-dom";
import { ThemeContext } from "./ThemeContext";

export const ClientContext = createContext()



const ClientProvider = ({ children }) => {
    let location = useLocation();
    const [widthScreen, setWidthScreen] = useState();
    const { isAuthencated, user } = useSelector(state => state.auth)
    const [newNotifies, setNewNotifies] = useState({ data: [], totalUnread: 0, type: null, loading: true })
    const [dataMenu, setDataMenu] = useState([]);



    const getDataLayout = async () => {
        try {
            const response = await axios.get(`/api/get-all-setting-status`);

        } catch (error) {

        }
    }

    const { general, setGeneral } = useContext(ThemeContext);

    useEffect(() => {
        setWidthScreen(window.innerWidth);
        window.title = 'Trang chủ';

        const handleResize = () => {
            setWidthScreen(window.innerWidth);
        };
        window.addEventListener('resize', handleResize);
        return () => {
            window.removeEventListener('resize', handleResize);
        };
    }, [])



    useEffect(() => {
        window.scrollTo(0, 0);
    }, [location])


    return (
        <ClientContext.Provider
            value={{
                dataMenu, general, widthScreen, items, user, setDataMenu, setNewNotifies
            }}
        >
            {children}
        </ClientContext.Provider>
    )
}



export default ClientProvider;
