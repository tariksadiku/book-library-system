import React from "react";

const AuthorForm = ({
    data,
    setData,
    errors,
    processing,
    handleSubmit,
    submitLabel,
}) => {
    return (
        <form onSubmit={handleSubmit} className="space-y-5">
            <div>
                <label htmlFor="name" className="text-gray-700 font-medium">
                    Name
                </label>
                <input
                    type="text"
                    id="name"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                {errors.name && (
                    <p className="text-red-500 text-sm mt-1">{errors.name}</p>
                )}
            </div>

            <div>
                <label
                    htmlFor="birth_date"
                    className="text-gray-700 font-medium"
                >
                    Birthdate
                </label>
                <input
                    type="date"
                    id="birth_date"
                    value={data.birth_date}
                    onChange={(e) => setData("birth_date", e.target.value)}
                    className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                {errors.birth_date && (
                    <p className="text-red-500 text-sm mt-1">
                        {errors.birth_date}
                    </p>
                )}
            </div>

            <div>
                <label
                    htmlFor="biography"
                    className="text-gray-700 font-medium"
                >
                    Biography
                </label>
                <textarea
                    id="biography"
                    value={data.biography}
                    onChange={(e) => setData("biography", e.target.value)}
                    className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
                {errors.biography && (
                    <p className="text-red-500 text-sm mt-1">
                        {errors.biography}
                    </p>
                )}
            </div>

            <div>
                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    {submitLabel}
                </button>
            </div>
        </form>
    );
};

export default AuthorForm;
