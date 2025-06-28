import { User } from '@/contexts/ClienContext.types';
import ClientPath from '@/Routes/RoutePaths/CilenPath';
import { InboxOutlined, LogoutOutlined, UserOutlined } from '@ant-design/icons';
import { Avatar, Dropdown, MenuProps, Space } from "antd";
import { MdAddLocation } from "react-icons/md";
import { Link } from 'react-router-dom';
interface AuthPropsData {
    data: User | null
}


const DropDownAuth = ({ data }: AuthPropsData) => {
    console.log(data, 'data')
    const avatar = data?.avatar ? <Avatar src={data?.avatar as string} /> :
        (
            <Avatar style={{ backgroundColor: '#fde3cf', color: '#f56a00' }}>
                {data?.full_name?.[0]?.toUpperCase()}
            </Avatar>
        )

    const items: MenuProps['items'] = [
        {
            key: 'detail-user',
            label: <span><Avatar src={data?.avatar as string} /> <p className='fw-bold inline-block ml-2'>{data?.email}</p></span>,
        },
        {
            type: 'divider',
        },
        {
            key: 'account',
            label: <Link to={ClientPath.DETAIL_USER} >Thông tin tài khoản</Link>,
            icon: <UserOutlined />
        },

        {
            key: 'order',
            label: 'Đơn hàng',
            icon: <InboxOutlined />
        },
        {
            key: 'address',
            label: 'Địa chỉ',
            icon: <MdAddLocation />
        },
        {
            type: 'divider',
        },
        {
            key: 'logout',
            label: 'Đăng xuất',
            danger: true,
            icon: <LogoutOutlined />
        },
    ];

    return (
        <Dropdown menu={{ items }} trigger={['click']} className='max-w-[400px]'>
            {/* <Link to={'#'} onClick={(e) => e.preventDefault()} className='px-3 h-full'> */}
            <Space className='h-full px-3 cursor-pointer'>
                {avatar}
                <div className="flex flex-col">
                    <span className="text-gray-500 text-base">Xin chào</span>
                    <span className="text-gray-500 text-base">{data?.full_name.length > 10 ? `${data?.full_name.slice(0, 10)}...` : data?.full_name}</span>
                </div>

            </Space>
            {/* </Link> */}
        </Dropdown>

    )



}


export default DropDownAuth;
