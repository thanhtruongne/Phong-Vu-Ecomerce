import useDebounce from "@/hook/useDebounce";
import { SearchOutlined } from "@ant-design/icons";
import { Input } from "antd";
import { useEffect, useState } from "react";

type SearchResult = { id: number; name: string }[];


const SearchHome = ({ classNames }) => {
    const [searchTerm, setSearchTerm] = useState<string>("");
    const [results, setResults] = useState<SearchResult>([]);
    const debouncedSearchTerm = useDebounce(searchTerm, 800);

    useEffect(() => {
        console.log(debouncedSearchTerm, 'debouncedSearchTerm')
        if (debouncedSearchTerm) {
            // Gọi API hoặc xử lý tìm kiếm tại đây
            // handleSearchingData(debouncedSearchTerm);
        } else {
            setResults([]);
        }
    }, [debouncedSearchTerm]);

    // const handleSearchingData = async (data: string): Promise<void> => {
    //     try {
    //         const response = await fetch(`https://api.example.com/search?query=${data}`);
    //         const result: SearchResult = await response.json();
    //         setResults(result);
    //     } catch (error) {
    //         console.error("Error fetching search results:", error);
    //         setResults([]);
    //     }
    // }

    const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSearchTerm(e.target.value);
    };

    return (
        <div className="relative">
            {/* <Space className={classNames}> */}
            <Input
                name="searchHeader"
                className={classNames}
                prefix={<SearchOutlined />}
                placeholder={'Tìm kiếm'}
                // style={{ width: '300px' }}

                onChange={handleInputChange}
            />
            {/* </Space> */}
        </div>
    )
}


export default SearchHome
