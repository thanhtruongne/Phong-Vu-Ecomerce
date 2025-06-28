import { SendOutlined } from '@ant-design/icons';
import { Button, FloatButton } from 'antd';
import { useEffect, useState } from 'react';

const ScrollPage = () => {
    const [showButton, setShowButton] = useState<Boolean>(false);

    const handleScroll = () => {
        if (window.scrollY > 0) {
            setShowButton(true);
        } else {
            setShowButton(false);
        }
    };

    useEffect(() => {
        window.addEventListener('scroll', handleScroll);
        return () => {
            window.removeEventListener('scroll', handleScroll);
        };
    }, []);

    return (
        <>
            {showButton && (
                <FloatButton.BackTop style={{ display: 'inline-block' }} icon={<SendOutlined rotate={-90} />}>
                    <Button type="default" shape="circle" style={{ height: "39px", width: "39px" }} />
                </FloatButton.BackTop>
            )}

        </>
    );
};

export default ScrollPage;
