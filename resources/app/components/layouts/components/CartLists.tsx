import { Button, Divider, List } from 'antd';


const CartList = () => {
    const cartItems = [
        {
            id: 1,
            name: 'Bộ vi xử lý/ CPU Intel Core Ultra 7 265K',
            image: 'https://phongvu.vn/media/catalog/product/i/n/intel-core-ultra-7-265k.jpg',
            price: 9990000,
            quantity: 1,
            desc: '20C - 20T | 30M Cache | Upto 5.5GHz',
        },
        {
            id: 2,
            name: 'Ổ cứng SSD WD Green 2.5" 240GB SATA III',
            image: 'https://phongvu.vn/media/catalog/product/w/d/wds240g3g0a.jpg',
            price: 579000,
            quantity: 2,
            desc: '240GB, Xanh lá',
        },
    ];

    const totalItems = cartItems.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);

    return (
        <div style={{ width: 340, maxHeight: 400, overflowY: 'auto', padding: 12 }}>
            <List
                itemLayout="horizontal"
                className='overflow-y-auto'
                dataSource={cartItems}
                renderItem={item => (
                    <List.Item>
                        <List.Item.Meta
                            avatar={<img src={item.image} alt={item.name} width={48} height={48} style={{ borderRadius: 6, objectFit: 'cover' }} />}
                            title={<span style={{ fontWeight: 500, fontSize: 14 }}>{item.name}</span>}
                            description={
                                <>
                                    <div style={{ fontSize: 13, color: '#888' }}>{item.desc}</div>
                                    <div style={{ fontSize: 13, color: '#888' }}>Số lượng {item.quantity}</div>
                                    <div style={{ fontWeight: 600, color: '#222', fontSize: 15 }}>
                                        {item.price.toLocaleString('vi-VN')}<span style={{ fontSize: 13 }}>đ</span>
                                    </div>
                                </>
                            }
                        />
                    </List.Item>
                )}
            />
            <Divider style={{ margin: '12px 0' }} />
            <div style={{ display: 'flex', justifyContent: 'space-between', fontWeight: 500, fontSize: 15 }}>
                <span>Tổng tiền ({totalItems} sản phẩm)</span>
                <span style={{ color: '#1677ff', fontWeight: 700, fontSize: 18 }}>
                    {totalPrice.toLocaleString('vi-VN')}đ
                </span>
            </div>
            <Button
                type="primary"
                block
                style={{ marginTop: 14, fontWeight: 600, fontSize: 16 }}
                onClick={() => window.location.href = '/cart'}
            >
                Xem giỏ hàng
            </Button>
        </div>
    )
}

export default CartList;
