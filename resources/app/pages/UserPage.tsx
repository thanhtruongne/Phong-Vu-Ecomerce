
import UserInfo from "@/components/common/Auth/UserInfo";
import { useClient } from "@/contexts/ClientProvider";
import { HistoryOutlined, LogoutOutlined, ShopOutlined, UserOutlined } from "@ant-design/icons";
import { Layout, Menu } from "antd";
import { Content } from "antd/es/layout/layout";
import Sider from "antd/es/layout/Sider";
import { useState } from "react";


const UserPage = () => {
    const { user } = useClient();
    const [selectedKey, setSelectedKey] = useState<string>('account')

    const renderComponent = (key: string) => {
        switch (key) {
            case 'account':
                return <UserInfo />;
            case 'order':
                return <div className="">123213213</div>;
            default:
                return <UserInfo />;
        }
    };

    const menuItems = [
        { key: 'overview', icon: <ShopOutlined />, label: 'Tổng quan' },
        { key: 'history_buy', icon: <HistoryOutlined />, label: 'Lịch sử mua hàng' },
        { key: 'account', icon: <UserOutlined />, label: 'Thông tin tài khoản' },
        { type: 'divider' },
        {
            key: 'logout',
            label: <span>Đăng xuất</span>,
            danger: true,
            icon: <LogoutOutlined />
        },
    ];


    return (
        <div className="my-3 mx-auto container max-w-[1112px] custom-item-menu">
            <Layout >
                <Sider width={250} style={{ borderRadius: '3rem' }}>
                    <Menu
                        mode="inline"
                        selectedKeys={[selectedKey]}
                        onSelect={({ key }) => setSelectedKey(key)}
                        style={{ height: '100%', borderRight: 0, padding: '6px' }}
                        items={menuItems}
                    />
                </Sider>
                <Layout className="ml-3">
                    <Content style={{ borderRadius: '1rem' }}>
                        {renderComponent(selectedKey)}
                    </Content>
                </Layout>
            </Layout>
        </div>
    )

}


export default UserPage;
