import React, { useState } from "react";
import { useForm, router, Link, Head } from "@inertiajs/react";
import BookForm from "@components/forms/BookForm";
import toast from "react-hot-toast";

const Create = ({ authors, filters }) => {
    const { data, setData, post, processing, errors } = useForm({
        title: "",
        isbn: "",
        author_id: "",
    });

    const [search, setSearch] = useState(filters.search || "");

    const handleSearch = (e) => {
        e.preventDefault();
        router.get(
            "/books/create",
            {
                search: search,
            },
            { preserveState: true }
        );
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/books", {
            onSuccess: () => {
                toast.success("Book created successfully");
            },
        });
    };

    return (
        <div className="bg-gray-50 p-6 rounded-lg shadow-lg">
            <Head title="Create Book" />
            <h1 className="text-gray-800 text-3xl font-semibold mb-6">
                Create Book
            </h1>

            <BookForm
                data={data}
                handleSubmit={handleSubmit}
                setData={setData}
                errors={errors}
                processing={processing}
                submitLabel="Create Book"
                authors={authors.data}
                search={search}
                setSearch={setSearch}
                handleSearch={handleSearch}
            />

            <div className="mt-6 text-center">
                <Link href="/books" className="text-blue-600 hover:underline">
                    Back to books list
                </Link>
            </div>
        </div>
    );
};

export default Create;
