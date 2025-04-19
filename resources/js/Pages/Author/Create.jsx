import React from "react";
import { useForm, Head } from "@inertiajs/react";
import { Link } from "@inertiajs/react";
import AuthorForm from "@components/forms/AuthorForm";
import toast from "react-hot-toast";

const Create = () => {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        birth_date: "",
        biography: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/authors", {
            onSuccess: () => {
                toast.success("Author created successfully");
            },
        });
    };

    return (
        <div className="bg-gray-50 p-6 rounded-lg shadow-lg">
            <Head title="Create Author" />
            <h1 className="text-gray-800 text-3xl font-semibold mb-6">
                Create Author
            </h1>

            <AuthorForm
                data={data}
                handleSubmit={handleSubmit}
                setData={setData}
                errors={errors}
                processing={processing}
                submitLabel="Create Author"
            />

            <div className="mt-6 text-center">
                <Link href="/authors" className="text-blue-600 hover:underline">
                    Back to authors list
                </Link>
            </div>
        </div>
    );
};

export default Create;
