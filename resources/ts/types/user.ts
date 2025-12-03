export interface User {
    id: number;
    email: string;
    name: string;
    status: string,
    email_verified_at: Date | null;
    created_at: Date;
    updated_at: Date;
}
