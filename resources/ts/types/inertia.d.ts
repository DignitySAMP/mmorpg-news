import { User } from '@/types/user';
import type { Page } from '@inertiajs/core';

declare module '@inertiajs/core' {
    interface PageProps extends Page<PageProps> {
        auth: User | null;
    }
}
