import React from "react";

const SearchForm = ({
    value,
    onChange,
    onSubmit,
    placeholder = "Search...",
    buttonText = "Search",
}) => {
    return (
        <form onSubmit={onSubmit} className="mb-4 w-full flex">
            <input
                type="text"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                placeholder={placeholder}
                className="px-4 py-2 border rounded shadow-sm w-full"
            />
            <button
                type="submit"
                className="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            >
                {buttonText}
            </button>
        </form>
    );
};

export default SearchForm;
