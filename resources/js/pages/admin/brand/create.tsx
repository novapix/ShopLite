import React from "react";
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { BreadcrumbItem } from '@/types/index';
// import { useAppearance } from '@/hooks/use-appearance';
import { useForm } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Switch } from "@/components/ui/switch";

type FormData = {
  name: string;
    description: string;
    status: boolean;
    image: File | null;
};
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Admin Dashboard',
            href: '/admin',
        },
        {
            title: 'Brands',
            href: '/admin/brand',
        },
        {
            title: 'Create Brand',
            href: '/admin/brand/create',
        },
    ];

export default function Create() {
    // const { appearance } = useAppearance();

    const { data, setData, post, processing, errors, reset } = useForm<FormData>({
        name: "",
        description: "",
        status: true,
        image: null,
    });

    function submit(e: React.FormEvent) {
        e.preventDefault();
        post(route("admin.brand.store"), {
            forceFormData: true,
            onSuccess: () => reset(),
        });
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Brand" />
            <div className="flex h-full flex-1 items-center justify-center p-6">
                <div className="w-full max-w-lg">
                    <div className="bg-card shadow-2xl border border-border rounded-xl p-8 transition-all duration-200">
                        <h1 className="text-2xl font-bold mb-6 text-card-foreground text-center transition-colors duration-200">
                            Create Brand
                        </h1>
                        <form onSubmit={submit} encType="multipart/form-data" className="space-y-6">
                            <div className="space-y-2">
                                <label htmlFor="name" className="block font-semibold text-sm text-foreground transition-colors duration-200">
                                    Name
                                </label>
                                <Input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={e => setData("name", e.target.value)}
                                    placeholder="Enter brand name"
                                    autoFocus
                                    className="w-full bg-input text-foreground border border-border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 placeholder:text-muted-foreground hover:border-border"
                                />
                                {errors.name && <div className="text-destructive text-xs transition-colors duration-200">{errors.name}</div>}
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="description" className="block font-semibold text-sm text-foreground transition-colors duration-200">
                                    Description
                                </label>
                                <Textarea
                                    id="description"
                                    value={data.description}
                                    onChange={(e: { target: { value: string; }; }) => setData("description", e.target.value)}
                                    placeholder="Describe the brand (optional)"
                                    rows={3}
                                    className="w-full bg-input text-foreground border border-border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 placeholder:text-muted-foreground hover:border-border"
                                />
                                {errors.description && <div className="text-destructive text-xs transition-colors duration-200">{errors.description}</div>}
                            </div>
                            <div className="space-y-2">
                                <label htmlFor="image" className="block font-semibold text-sm text-foreground transition-colors duration-200">
                                    Brand Image
                                </label>
                                <Input
                                    id="image"
                                    type="file"
                                    accept="image/*"
                                    onChange={e => setData("image", e.target.files ? e.target.files[0] : null)}
                                    className="w-full bg-input text-foreground border border-border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 placeholder:text-muted-foreground hover:border-border"
                                />
                                {errors.image && <div className="text-destructive text-xs transition-colors duration-200">{errors.image}</div>}
                            </div>
                            <div className="flex items-center gap-2 p-3 rounded-lg bg-muted border border-border transition-all duration-200">
                                <Switch
                                    id="status"
                                    checked={data.status}
                                    onCheckedChange={(checked: boolean) => setData("status", checked)}
                                    className="bg-input border-border focus:ring-primary focus:ring-2 accent-primary transition-colors duration-200"
                                />
                                <label htmlFor="status" className="font-semibold text-sm text-foreground transition-colors duration-200">
                                    Active Status
                                </label>
                                {errors.status && <div className="text-destructive text-xs ml-2 transition-colors duration-200">{errors.status}</div>}
                            </div>
                            <Button
                                type="submit"
                                disabled={processing}
                                className="w-full text-lg font-semibold bg-primary hover:bg-primary-foreground text-primary-foreground rounded px-4 py-3 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                {processing ? (
                                    <span className="flex items-center justify-center gap-2">
                                        <svg className="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" fill="none" />
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                        Saving...
                                    </span>
                                ) : "Save Brand"}
                            </Button>
                        </form>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}