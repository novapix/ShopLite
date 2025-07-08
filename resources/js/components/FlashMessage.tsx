import React from "react";

type FlashProps = {
    flash?: {
        success?: string;
        error?: string;
    };
};

const FlashMessage: React.FC<FlashProps> = ({ flash }) => {
    if (!flash) return null;

    if (flash.success) {
        return (
            <div className="bg-green-100 text-green-700 p-3 rounded mb-4">
                {flash.success}
            </div>
        );
    }

    if (flash.error) {
        return (
            <div className="bg-red-100 text-red-700 p-3 rounded mb-4">
                {flash.error}
            </div>
        );
    }

    return null;
};

export default FlashMessage;
