import React from "react";
import { useForm } from "@inertiajs/react";

type FormData = {
    name: string;
    status: boolean;
};

export default function Create() {
    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        name: "",
        status: true,
    });

    function submit(e: React.FormEvent) {
        e.preventDefault();
        post(route("admin.role.store"), {
            onSuccess: () => reset(),
        });
    }

    return (
        <div className="max-w-md mx-auto p-4">
            <h1 className="text-2xl font-bold mb-4">Create Role</h1>


            <form onSubmit={submit}>
                <div className="mb-4">
                    <label className="block mb-1 font-semibold" htmlFor="name">
                        Role Name
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
                    {processing ? "Saving..." : "Save Role"}
                </button>
            </form>
        </div>
    );
}
