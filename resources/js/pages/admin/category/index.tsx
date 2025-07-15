import React from "react";
import { usePage, router } from "@inertiajs/react";
import { PageProps } from "@/types/inertia";
import FlashMessage from "@/components/FlashMessage";

type Category = {
    id: number;
    name: string;
    description: string;
    status: boolean
};

const CategoryIndex = () => {
    const { categories, flash } = usePage<PageProps<{ categories: Category[] }>>().props;
    const handleDelete = (id: number) => {
        if (confirm("Are you sure you want to delete this category?")) {
            router.delete(`/categories/${id}`);
        }
    };

    return (
        <div className="p-6">
            <h1 className="text-2xl font-bold mb-4">Categories</h1>

            {/* Flash Message */}
            <FlashMessage flash={flash} />


            {/* Category List */}
            <ul className="space-y-2">
                {categories.map((category) => (
                    <li key={category.id} className="flex justify-between items-center border p-3 rounded">
                        <span>{category.name}</span>
                        <button
                            onClick={() => handleDelete(category.id)}
                            className="text-red-500 hover:text-red-700"
                        >
                            Disable
                        </button>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default CategoryIndex;
