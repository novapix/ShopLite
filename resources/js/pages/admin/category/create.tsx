import React from "react";
import { useForm } from "@inertiajs/react";

type FormData = {
    name: string;
    description: string;
    status: boolean;
};

export default function Create() {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        name: "",
        description: "",
        status: true,
    });

    function submit(e: React.FormEvent) {
        e.preventDefault();
        post(route("admin.category.store"), {
            onSuccess: () => reset(),
        });
    }

    return (
        <div className="max-w-md mx-auto p-4">
            <h1 className="text-2xl font-bold mb-4">Create Product Category</h1>


            <form onSubmit={submit}>
                <div className="mb-4">
                    <label className="block mb-1 font-semibold" htmlFor="name">
                        Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                    />
                    {errors.name && (
                        <div className="text-red-600 text-sm mt-1">{errors.name}</div>
                    )}
                </div>

                <div className="mb-4">
                    <label className="block mb-1 font-semibold" htmlFor="description">
                        Description
                    </label>
                    <textarea
                        id="description"
                        value={data.description}
                        onChange={(e) => setData("description", e.target.value)}
                        className="w-full border border-gray-300 rounded px-3 py-2"
                        rows={3}
                    />
                    {errors.description && (
                        <div className="text-red-600 text-sm mt-1">{errors.description}</div>
                    )}
                </div>

                <div className="mb-4">
                    <label className="inline-flex items-center">
                        <input
                            type="checkbox"
                            checked={data.status}
                            onChange={(e) => setData("status", e.target.checked)}
                            className="mr-2"
                        />
                        Active
                    </label>
                    {errors.status && (
                        <div className="text-red-600 text-sm mt-1">{errors.status}</div>
                    )}
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="bg-blue-600 text-white rounded px-4 py-2 hover:bg-blue-700 disabled:opacity-50"
                >
                    {processing ? "Saving..." : "Save Category"}
                </button>
            </form>
        </div>
    );
}
