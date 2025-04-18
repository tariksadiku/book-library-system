import React from "react";

const ErrorPage = ({ message }) => {
    return (
        <div className="flex w-full">
            <div className="bg-white p-8 rounded shadow-lg w-full">
                <h1 className="text-2xl font-semibold text-red-500">Error</h1>
                <p className="mt-4 text-lg text-gray-700">{message}</p>
            </div>
        </div>
    );
};

export default ErrorPage;
