import { useClient } from "@/contexts/ClientProvider";
import { Layout, Skeleton } from "antd";
import { useEffect } from "react";
import { Outlet, useLocation } from "react-router-dom";
import HeaderVertical from "./containers/HeaderVertical";

const LayoutHorizon = () => {
    const location = useLocation()
    const { isLoading } = useClient()

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [location])


    return (
        <Layout id="layout-data" >
            {isLoading ? <Skeleton active paragraph={{ rows: 16 }} /> : (
                <div className="w-100">
                    <div id="header">
                        <HeaderVertical />
                    </div>

                    <Layout.Content>
                        <div className="w-100">
                            <Outlet />
                        </div>
                    </Layout.Content>

                </div>
            )}
        </Layout>

    )
}

export default LayoutHorizon
