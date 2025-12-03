import { type User } from '@/types/user'

export interface ArticleComment {
    id: number;
    article_id: number;
    user_id: number;
    author: User;
    text: string;
    created_at: Date;
    updated_at: Date;
}

export interface ArticleImage {
    id: number;
    article_id: number;
    name: string;
    description: string;
    image: string;
    created_at: Date;
    updated_at: Date;
}

export interface Article {
    id: number;
    user_id: number;
    user: User;
    banner: string | null;
    title: string;
    content: string;
    created_at: Date;
    updated_at: Date;
    read_time: number;
    comments_count?: number;
    similar_articles?: Article[];
    comments?: ArticleComment[];
    images?: ArticleImage[];
}
