import React from "react";
import SearchForm from "@components/SearchForm";
import { Link } from "@inertiajs/react";
import { Head } from "@inertiajs/react";

const BookForm = ({
    data,
    setData,
    errors,
    processing,
    handleSubmit,
    submitLabel,
    authors = [],
    search,
    setSearch,
    handleSearch,
    selectedAuthorId,
}) => {
    return (
        <>
            <Head title="Update Book" />
            <SearchForm
                value={search}
                onChange={setSearch}
                onSubmit={handleSearch}
                placeholder="Search Authors"
            />
            <form onSubmit={handleSubmit} className="space-y-5">
                <div>
                    <label
                        htmlFor="title"
                        className="text-gray-700 font-medium"
                    >
                        Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        value={data.title}
                        onChange={(e) => setData("title", e.target.value)}
                        className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    {errors.title && (
                        <p className="text-red-500 text-sm mt-1">
                            {errors.title}
                        </p>
                    )}
                </div>

                <div>
                    <label htmlFor="isbn" className="text-gray-700 font-medium">
                        ISBN
                    </label>
                    <input
                        type="text"
                        id="isbn"
                        value={data.isbn}
                        onChange={(e) => setData("isbn", e.target.value)}
                        className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    {errors.isbn && (
                        <p className="text-red-500 text-sm mt-1">
                            {errors.isbn}
                        </p>
                    )}
                </div>
                <div>
                    <label
                        htmlFor="author_id"
                        className="text-gray-700 font-medium"
                    >
                        Author
                    </label>
                    {authors.length > 0 ? (
                        <select
                            id="author_id"
                            value={selectedAuthorId}
                            onChange={(e) =>
                                setData("author_id", e.target.value)
                            }
                            className="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Select an author</option>
                            {authors.map((author) => (
                                <option key={author.id} value={author.id}>
                                    {author.name}
                                </option>
                            ))}
                        </select>
                    ) : (
                        <p className="text-gray-500 mt-2">
                            No authors found,
                            <Link
                                href="/authors/create"
                                className="text-blue-500 hover:underline"
                            >
                                {" "}
                                Create one
                            </Link>
                        </p>
                    )}
                    {errors.author_id && (
                        <p className="text-red-500 text-sm mt-1">
                            {errors.author_id}
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
        </>
    );
};

export default BookForm;
