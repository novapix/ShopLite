export type PageProps<T = object> = T & {
    auth?: {
        user: {
            id: number;
            name: string;
            email: string;
        };
    };
    flash?: {
        success?: string;
        error?: string;
    };
};
