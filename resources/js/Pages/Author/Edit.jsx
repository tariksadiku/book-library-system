import React from "react";
import { useForm } from "@inertiajs/react";
import { Link } from "@inertiajs/react";
import AuthorForm from "@components/forms/AuthorForm";
import toast from "react-hot-toast";

const Edit = ({ author }) => {
    const { data, setData, put, processing, errors } = useForm({
        name: author.data.name,
        birth_date: author.data.birth_date,
        biography: author.data.biography,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put(`/authors/${author.data.id}`, {
            onSuccess: () => {
                toast.success("Author updated successfully");
            },
        });
    };

    return (
        <div className="bg-gray-50 p-6 rounded-lg shadow-lg">
            <h1 className="text-gray-800 text-3xl font-semibold mb-6">
                Update Author
            </h1>

            <AuthorForm
                data={data}
                handleSubmit={handleSubmit}
                setData={setData}
                errors={errors}
                processing={processing}
                submitLabel="Update Author"
            />

            <div className="mt-6 text-center">
                <Link href="/authors" className="text-blue-600 hover:underline">
                    Back to authors list
                </Link>
            </div>
        </div>
    );
};

export default Edit;
