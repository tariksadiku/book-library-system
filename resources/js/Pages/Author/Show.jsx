import React, { useState } from "react";
import { Link, router, Head } from "@inertiajs/react";
import ConfirmDialog from "@components/ConfirmDialog";
import toast from "react-hot-toast";

const Show = (props) => {
    const author = props.author.data;
    const [showModal, setShowModal] = useState(false);

    const handleDelete = () => {
        router.delete(`/authors/${author.id}`, {
            onSuccess: () => {
                toast.success("Author deleted successfully");
            },
        });
    };

    return (
        <div className="max-w-2xl mx-auto p-6 bg-white rounded shadow">
            <Head title={`Author: ${author.name}`} />
            <ConfirmDialog
                show={showModal}
                title="Delete Author"
                message="Are you sure you want to delete this author? This action cannot be undone."
                confirmText="Delete"
                cancelText="Cancel"
                onCancel={() => setShowModal(false)}
                onConfirm={handleDelete}
            />
            <h1 className="text-3xl font-bold text-gray-800 mb-4">
                {author.name}
            </h1>
            <div className="space-y-2 mb-6">
                <p>
                    <strong className="text-gray-700">Birthdate:</strong>{" "}
                    {author.birth_date}
                </p>
                <p>
                    <strong className="text-gray-700">Biography:</strong>{" "}
                    {author.biography}
                </p>
            </div>

            <div className="mb-6">
                <h2 className="text-xl font-semibold text-gray-800 mb-2">
                    Books
                </h2>
                {author.books?.length > 0 ? (
                    <div className="py-2 bg-white">
                        <ul className="list-disc list-inside space-y-1">
                            {author.books.map((book) => (
                                <li key={book.id}>
                                    <Link
                                        href={`/books/${book.id}`}
                                        className="text-blue-600 hover:underline"
                                    >
                                        {book.title}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                ) : (
                    <p className="text-gray-500">No books available.</p>
                )}
            </div>

            <div className="flex flex-col items-center gap-4">
                <div className="flex justify-between items-center gap-4">
                    <button
                        onClick={() => setShowModal(true)}
                        className="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 hover:cursor-pointer"
                    >
                        Delete Author
                    </button>
                    <Link
                        href={`/authors/${author.id}/edit`}
                        className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Edit
                    </Link>
                </div>
                <Link href="/authors" className="text-blue-600 hover:underline">
                    ← Back to authors
                </Link>
            </div>
        </div>
    );
};

export default Show;
