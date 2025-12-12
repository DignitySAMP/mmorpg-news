export interface MinimumSystemRequirements {
    os: string;
    processor: string;
    memory: string;
    graphics: string;
    storage: string;
}

export interface Game {
    id: number;
    title: string;
    thumbnail: string;
    short_description: string;
    description: string;
    genre: string;
    platform: string;
    publisher: string;
    developer: string;
    release_date: string;
    minimum_system_requirements: MinimumSystemRequirements | null;
    screenshots: string[];
    created_at: string;
    updated_at: string;
}
