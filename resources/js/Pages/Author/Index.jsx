import React from "react";
import { Link, router } from "@inertiajs/react";
import { Head } from "@inertiajs/react";
import Pagination from "@components/Pagination";
import useFilters from "@hooks/useFilters";
import SearchForm from "@components/SearchForm";
import TableHead from "@components/table/TableHeader";

const Index = ({ authors, filters }) => {
    const { search, setSearch } = useFilters(filters);

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(
            "/authors",
            {
                ...filters,
                search: search,
            },
            { preserveState: true }
        );
    };

    const handleSort = (column) => {
        router.get(
            "/authors",
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
        { name: "name", label: "Name" },
        { name: "birth_date", label: "Birth Date" },
        { name: "biography", label: "Biography" },
    ];

    return (
        <div className="relative overflow-x-auto sm:rounded-lg items-center">
            <Head title="Authors" />
            <h1 className="text-black-500 text-3xl font-semibold mb-4">
                Authors
            </h1>

            {authors.data.length !== 0 && (
                <SearchForm
                    value={search}
                    onChange={setSearch}
                    onSubmit={handleSearch}
                    placeholder="Search authors"
                />
            )}

            {authors.data.length === 0 ? (
                <p className="text-black-500">No authors available.</p>
            ) : (
                <table className="w-full">
                    <TableHead
                        columns={columns}
                        sortColumn={filters?.sort?.column}
                        onSort={handleSort}
                    />
                    <tbody>
                        {authors.data.map((author) => (
                            <tr
                                key={author.id}
                                className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                            >
                                <td className="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                    {author.name}
                                </td>
                                <td className="px-6 py-4">
                                    {author.birth_date}
                                </td>
                                <td className="px-6 py-4">
                                    {author.biography}
                                </td>
                                <td className="px-6 py-4">
                                    <Link
                                        href={`/authors/${author.id}`}
                                        className="text-blue-500 hover:underline"
                                    >
                                        Go to author
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}
            <Pagination links={authors?.meta?.links} />

            <div className="mt-6 w-full text-center">
                <Link
                    href="/authors/create"
                    className="text-blue-500 underline"
                >
                    Click here to create a new author
                </Link>
            </div>
        </div>
    );
};

export default Index;
