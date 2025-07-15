import React from "react";
import { usePage, router } from "@inertiajs/react";
import { PageProps } from "@/types/inertia";
import FlashMessage from "@/components/FlashMessage";

type Role = {
    id: number;
    role: string;
    is_active: boolean
};

const RolesIndex = () => {
    const { roles, flash } = usePage<PageProps<{ roles: Role[] }>>().props;
    console.log(roles);

    const handleDelete = (id: number) => {
        if (confirm("Are you sure you want to deactivate this Role?")) {
            router.delete(`/admin/roles/${id}`);
        }
    };

    const handleCreateRole = () => {
        router.visit('/admin/roles/create');
    };

    return (
        <div className="p-6">
            <div className="flex justify-between items-center mb-4">
                <h1 className="text-2xl font-bold">Roles</h1>
                <button
                    onClick={handleCreateRole}
                    className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    Create Role
                </button>
            </div>

            {/* Flash Message */}
            <FlashMessage flash={flash} />

            {/* Role List */}
            <ul className="space-y-2">
                {roles.map((role) => (
                    <li key={role.id} className="flex justify-between items-center border p-3 rounded">
                        <span>{role.role}</span>
                        <button
                            onClick={() => handleDelete(role.id)}
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

export default RolesIndex;
