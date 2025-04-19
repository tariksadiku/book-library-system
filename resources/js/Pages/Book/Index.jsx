import React from "react";
import { Link, router } from "@inertiajs/react";
import { Head } from "@inertiajs/react";
import Pagination from "@components/Pagination";
import useFilters from "@hooks/useFilters";
import SearchForm from "@components/SearchForm";
import TableHead from "@components/table/TableHeader";

const Index = ({ books, filters }) => {
    const { search, setSearch } = useFilters(filters);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(
            "/books",
            {
                ...filters,
                search: search,
            },
            { preserveState: true }
        );
    };

    const handleSort = (column) => {
        console.log(filters);
        router.get(
            "/books",
            {
                ...filters,
                sort: {
                    column: column,
                    direction:
                        filters?.sort?.direction === "asc" ? "desc" : "asc",
                },
            },
            { preserveState: true }
        );
    };

    const columns = [
        { name: "title", label: "Title" },
        { name: "isbn", label: "ISBN" },
        { name: "author", label: "Author" },
    ];

    return (
        <div className="relative overflow-x-auto sm:rounded-lg items-center">
            <Head title="Books" />
            <h1 className="text-black-500 text-3xl font-semibold mb-4">
                Books
            </h1>
            {books.data.length !== 0 && (
                <SearchForm
                    value={search}
                    onChange={setSearch}
                    onSubmit={handleSearch}
                    placeholder="Search books"
                />
            )}
            {books.data.length === 0 ? (
                <p className="text-black-500">No books available.</p>
            ) : (
                <table className="w-full">
                    <TableHead
                        columns={columns}
                        sortColumn={filters?.sort?.column}
                        onSort={handleSort}
                    />
                    <tbody>
                        {books.data.map((book) => (
                            <tr
                                key={book.id}
                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                            >
                                <td className="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {book.title}
                                </td>
                                <td className="px-6 py-4">{book.isbn}</td>
                                <td className="px-6 py-4">
                                    {book.author?.name ?? "Unknown"}
                                </td>
                                <td className="px-6 py-4">
                                    <Link
                                        href={`/books/${book.id}`}
                                        className="text-blue-500 hover:underline"
                                    >
                                        Go to book
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
            <Pagination links={books?.meta?.links} />

            <div className="mt-6 w-full text-center">
                <Link href="/books/create" className="text-blue-500 underline">
                    Click here to create a new book
                </Link>
            </div>
        </div>
    );
};

export default Index;
