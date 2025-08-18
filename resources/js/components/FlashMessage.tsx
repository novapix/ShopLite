import { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import { toast, Toaster } from 'react-hot-toast';

const FlashMessage = () => {
    const { flash } = usePage().props as { flash?: { success?: string; error?: string } };

    useEffect(() => {
        if (flash?.success) {
            toast.success(flash.success);
        }
        if (flash?.error) {
            toast.error(flash.error);
        }
    }, [flash?.success, flash?.error]);

    return <Toaster position="top-right" toastOptions={{ duration: 5000 }} />;
};

export default FlashMessage;
