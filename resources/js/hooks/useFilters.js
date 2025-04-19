import { useState } from "react";

const useFilters = (initialFilters = {}) => {
    const [search, setSearch] = useState(initialFilters.search || "");

    return {
        search,
        setSearch,
    };
};

export default useFilters;
