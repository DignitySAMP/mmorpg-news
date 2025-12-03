import type { Page } from '@inertiajs/core';
import { User } from '@/types/user';

declare module '@inertiajs/core' {
    interface PageProps extends Page<PageProps> {
        auth: User | null
    }
}