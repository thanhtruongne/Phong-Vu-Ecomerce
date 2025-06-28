import { useClient } from '@/contexts/ClientProvider';
import { BellOutlined, ShoppingCartOutlined } from '@ant-design/icons';
import { Badge, Popover, Skeleton, Space, Tooltip } from "antd";
import { MdApartment, MdBuild, MdContacts, MdHomeWork, MdLaptop, MdOutlineLogin } from "react-icons/md";
import { Link, useLocation, useNavigate } from "react-router-dom";
import CartList from '../components/CartLists';
import DropDownAuth from '../components/DropDownAuth';
import DropDownMenu from "../components/DropDownMenu";
import NotifyList from '../components/NotifyListItem';
import SearchHome from "../components/SearchHome";
const HeaderVertical = () => {
    const { isAuthenticated, isLoading, user, newNotifies, dataCategories, isLoadingUser } = useClient();



    const navigate = useNavigate();
    const location = useLocation();


    const itemsNotification = [
        {

        }
    ]

    return (
        <>
            <div className="relative h-[42px]">
                <div className="h-full bg-primary">
                    <div className="container mx-auto h-full">
                        <div className="flex justify-center items-center h-full text-white gap-[40px]">
                            <Link to="#" className='flex items-center'>
                                <MdHomeWork className='mr-2' />
                                <span> Khuyến mại</span>
                            </Link>
                            <Link className="flex items-center" to="#">
                                <MdApartment className='mr-2' />
                                Hệ thống showroom
                            </Link>
                            <Link className="flex items-center" to="#">
                                <MdApartment className='mr-2' />
                                Tư vấn doanh nghiệp
                            </Link>
                            <Link className="flex items-center" to="#">
                                <MdContacts className='mr-2' />
                                Liên hệ
                            </Link>
                            <Link className="flex items-center" to="#">
                                <MdLaptop className='mr-2' />
                                Tin công nghệ
                            </Link>
                            <Link className="flex items-center" to="#">
                                <MdBuild className='mr-2' />
                                Xây dựng cấu hình
                            </Link>

                        </div>
                    </div>
                </div>
            </div>

            <div className="sticky top-0 bg-white" style={{ boxShadow: "0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1)" }}>
                <div className="container mx-auto flex justify-center">

                    <div className="flex h-[112px] w-[58rem] items-center justify-center gap-[20px]">
                        {/* logo */}
                        <div className="max-w-full relative flex-[0_0_auto] p">
                            <div className="flex items-center">
                                <Link to={'/'}>
                                    <div className="h-[35px] w-[35px] relative mr-2 overflow-hidden">
                                        <img src="https://shopfront-cdn.tekoapis.com/static/phongvu/logo.svg" className="w-100 h-[35px]" alt="" loading="lazy" decoding="async" />
                                    </div>
                                </Link>
                                <div className="ml-3">
                                    <DropDownMenu data={dataCategories} />
                                </div>
                            </div>
                        </div>

                        <div className="flex-[1_1_auto] relative max-w-full px-2">
                            <SearchHome classNames={'w-full h-[45px]'} />
                        </div>

                        {isLoadingUser ? (
                            <Space className='flex-[0_0_auto] max-w-[200px]'>
                                <Skeleton.Button active={true} size={'large'} shape={'circle'} block={true} />
                                <div className="">
                                    <Skeleton.Input active={true} size={'small'} className='mb-1' />
                                    <Skeleton.Input active={true} size={'small'} block={true} />
                                </div>
                            </Space>
                        ) : (isAuthenticated ? <DropDownAuth data={user} /> : (
                            <div className="flex-[0_0_auto] max-w-full px-2">
                                <Link to={'/login'} className="flex items-center">
                                    <MdOutlineLogin size={20} className='mr-2' /> Đăng nhập
                                </Link>
                            </div>
                        ))}

                        <div className="flex-[0_0_auto] relative max-w-full px-2">
                            <Tooltip placement='top' title={"Thông báo"}>
                                <Popover
                                    content={<NotifyList data={newNotifies?.data} />}
                                    trigger="click"
                                    placement="bottomRight"
                                >
                                    <Badge count={99} overflowCount={20}>
                                        <BellOutlined className='text-[25px] cursor-pointer' />
                                    </Badge>
                                </Popover>
                            </Tooltip>
                        </div>
                        <div className="flex-[0_0_auto] relative max-w-full px-2">
                            <Tooltip placement='top' title={"Giỏ hàng"}>
                                <Popover
                                    trigger='click'
                                    className=''
                                    content={<CartList />}
                                    placement="bottom"
                                >
                                    <Badge overflowCount={20} count={0}>
                                        <div className="">
                                            <ShoppingCartOutlined className='text-[25px] cursor-pointer' />
                                        </div>
                                    </Badge>
                                </Popover>
                            </Tooltip>
                        </div>

                    </div>


                </div>
            </div >

        </>
    )
}


export default HeaderVertical;
