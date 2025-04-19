import React, { useState } from "react";
import { useForm } from "@inertiajs/react";
import { Link } from "@inertiajs/react";
import toast from "react-hot-toast";
import BookForm from "@components/forms/BookForm";

const Edit = ({ book, authors, filters }) => {
    const [search, setSearch] = useState(filters.search || "");
    const { data, setData, put, processing, errors } = useForm({
        title: book.data.title,
        isbn: book.data.isbn,
        author_id: book.data.author.id,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/books/${book.data.id}`, {
            onSuccess: () => {
                toast.success("Author updated successfully");
            },
        });
    };

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(
            "/books/edit",
            {
                search: search,
            },
            { preserveState: true }
        );
    };

    return (
        <div className="bg-gray-50 p-6 rounded-lg shadow-lg">
            <h1 className="text-gray-800 text-3xl font-semibold mb-6">
                Update Book
            </h1>
            <BookForm
                data={data}
                handleSubmit={handleSubmit}
                setData={setData}
                errors={errors}
                processing={processing}
                submitLabel="Update Book"
                authors={authors.data}
                search={search}
                setSearch={setSearch}
                handleSearch={handleSearch}
                selectedAuthorId={book.data.author.id}
            />

            <div className="mt-6 text-center">
                <Link href="/books" className="text-blue-600 hover:underline">
                    Back to books list
                </Link>
            </div>
        </div>
    );
};

export default Edit;
