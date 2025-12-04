export interface User {
    id: number;
    email: string;
    name: string;
    status: string;
    profile?: UserProfile;
    email_verified_at: Date | null;
    created_at: Date;
    updated_at: Date;
}

export interface UserProfile {
    id: number;
    user_id: number;
    age: number | string | null;
    location?: string | null;
    gender?: string | null;
    date_of_birth?: null | string | number | Date;
    show_profile: boolean;
    show_online_status: boolean;
    show_comments: boolean;
}
