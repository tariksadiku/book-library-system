import React, { useState } from "react";
import { Link, router, Head } from "@inertiajs/react";
import ConfirmDialog from "@components/ConfirmDialog";
import toast from "react-hot-toast";

const Show = (props) => {
    const book = props.book.data;
    const [showModal, setShowModal] = useState(false);

    const handleDelete = () => {
        router.delete(`/books/${book.id}`, {
            onSuccess: () => {
                toast.success("Book deleted successfully");
            },
        });
    };

    return (
        <div className="max-w-2xl mx-auto p-6 bg-white rounded shadow">
            <Head title={`Book: ${book.title}`} />
            <ConfirmDialog
                show={showModal}
                title="Delete Book"
                message="Are you sure you want to delete this book? This action cannot be undone."
                confirmText="Delete"
                cancelText="Cancel"
                onCancel={() => setShowModal(false)}
                onConfirm={handleDelete}
            />
            <h1 className="text-3xl font-bold text-gray-800 mb-4">
                {book.title}
            </h1>

            {book.cover_url && (
                <div className="mb-6">
                    <img
                        src={book.cover_url}
                        alt={book.title}
                        className="h-auto rounded shadow"
                    />
                </div>
            )}

            <div className="space-y-2 mb-6 text-gray-700">
                <p>
                    <strong>ISBN:</strong> {book.isbn}
                </p>
                {book.author && (
                    <p>
                        <strong>Author:</strong>{" "}
                        <Link
                            href={`/authors/${book.author.id}`}
                            className="text-blue-600 hover:underline"
                        >
                            {book.author.name}
                        </Link>
                    </p>
                )}
            </div>

            <div className="flex flex-col items-center gap-4">
                <div className="flex justify-between items-center gap-4">
                    <button
                        onClick={() => setShowModal(true)}
                        className="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 hover:cursor-pointer"
                    >
                        Delete Book
                    </button>
                    <Link
                        href={`/books/${book.id}/edit`}
                        className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Edit
                    </Link>
                </div>
                <Link href="/books" className="text-blue-600 hover:underline">
                    ← Back to books
                </Link>
            </div>
        </div>
    );
};

export default Show;
