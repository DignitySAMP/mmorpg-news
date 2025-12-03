export interface User {
    id: number;
    email: string;
    name: string;
    status: string;
    age: number | string | null;
    profile_location: string;
    profile_gender: string;
    profile_dob: Date;
    profile_privacy_online_status: boolean;
    profile_privacy_articles: boolean;
    profile_privacy_comments: boolean;
    email_verified_at: Date | null;
    created_at: Date;
    updated_at: Date;
}
