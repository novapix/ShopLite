import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import {
    Users,
    Package,
    Tag,
    ShoppingBag,
    UserCheck,
    Shield,
    TrendingUp,
    Activity,
    type LucideIcon
} from 'lucide-react';

interface Stats {
    total_categories: number;
    total_brands: number;
    total_customers: number;
    total_users?: number;
    total_roles?: number;
    total_admins?: number;
}

interface RecentItem {
    id: number;
    name?: string;
    email?: string;
    created_at: string;
}

interface RecentData {
    recent_categories: RecentItem[];
    recent_brands: RecentItem[];
    recent_customers: RecentItem[];
    recent_users?: RecentItem[];
}

interface AdminDashboardProps {
    stats: Stats;
    recentData: RecentData;
    userRole: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin Dashboard',
        href: '/admin',
    },
];

export default function AdminDashboard({ stats, recentData, userRole }: AdminDashboardProps) {
    const isSuperAdmin = userRole === 'superadmin';

    const StatCard = ({ title, value, icon: Icon, description, href }: {
        title: string;
        value: number;
        icon: LucideIcon;
        description: string;
        href?: string;
    }) => {
        const CardComponent = (
            <Card className="hover:shadow-md transition-shadow">
                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle className="text-sm font-medium">{title}</CardTitle>
                    <Icon className="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div className="text-2xl font-bold">{value}</div>
                    <p className="text-xs text-muted-foreground">{description}</p>
                </CardContent>
            </Card>
        );

        return href ? (
            <Link href={href} className="block">
                {CardComponent}
            </Link>
        ) : CardComponent;
    };

    const RecentItemsList = ({ title, items, href, type }: {
        title: string;
        items: RecentItem[];
        href: string;
        type: string;
    }) => (
        <Card>
            <CardHeader className="flex flex-row items-center justify-between">
                <div>
                    <CardTitle className="text-lg">{title}</CardTitle>
                    <CardDescription>Recently added {type}</CardDescription>
                </div>
                <Link
                    href={href}
                    className="text-sm text-primary hover:underline"
                >
                    View all
                </Link>
            </CardHeader>
            <CardContent>
                <div className="space-y-3">
                    {items.length > 0 ? (
                        items.map((item) => (
                            <div key={item.id} className="flex items-center justify-between border-b pb-2 last:border-b-0">
                                <div>
                                    <p className="font-medium">{item.name || item.email}</p>
                                    {item.email && <p className="text-sm text-muted-foreground">{item.email}</p>}
                                </div>
                                <Badge variant="outline" className="text-xs">
                                    {new Date(item.created_at).toLocaleDateString()}
                                </Badge>
                            </div>
                        ))
                    ) : (
                        <p className="text-sm text-muted-foreground">No {type} found</p>
                    )}
                </div>
            </CardContent>
        </Card>
    );

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Admin Dashboard" />

            <div className="flex h-full flex-1 flex-col gap-6 p-6">
                {/* Welcome Section */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold tracking-tight">Admin Dashboard</h1>
                        <p className="text-muted-foreground">
                            Welcome back! Here's what's happening in your store.
                        </p>
                    </div>
                    <div className="flex items-center gap-2">
                        <Badge variant={isSuperAdmin ? "default" : "secondary"}>
                            {isSuperAdmin ? "Super Admin" : "Admin"}
                        </Badge>
                        <Activity className="h-4 w-4" />
                    </div>
                </div>

                {/* Stats Grid */}
                <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <StatCard
                        title="Product Categories"
                        value={stats.total_categories}
                        icon={Package}
                        description="Total categories"
                        href="/admin/category"
                    />
                    <StatCard
                        title="Brands"
                        value={stats.total_brands}
                        icon={Tag}
                        description="Total brands"
                        href="/admin/brand"
                    />
                    <StatCard
                        title="Customers"
                        value={stats.total_customers}
                        icon={Users}
                        description="Total customers"
                    />

                    {/* Super Admin only stats */}
                    {isSuperAdmin && (
                        <>
                            <StatCard
                                title="Total Users"
                                value={stats.total_users || 0}
                                icon={UserCheck}
                                description="All system users"
                            />
                            <StatCard
                                title="Admin Users"
                                value={stats.total_admins || 0}
                                icon={Shield}
                                description="Admin level users"
                            />
                            <StatCard
                                title="User Roles"
                                value={stats.total_roles || 0}
                                icon={Shield}
                                description="Available roles"
                                href="/admin/roles"
                            />
                        </>
                    )}
                </div>

                {/* Recent Activity */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <RecentItemsList
                        title="Recent Categories"
                        items={recentData.recent_categories}
                        href="/admin/category"
                        type="categories"
                    />

                    <RecentItemsList
                        title="Recent Brands"
                        items={recentData.recent_brands}
                        href="/admin/brand"
                        type="brands"
                    />

                    <RecentItemsList
                        title="Recent Customers"
                        items={recentData.recent_customers}
                        href="#"
                        type="customers"
                    />

                    {/* Super Admin only recent activity */}
                    {isSuperAdmin && recentData.recent_users && (
                        <RecentItemsList
                            title="Recent Users"
                            items={recentData.recent_users}
                            href="#"
                            type="users"
                        />
                    )}
                </div>

                {/* Quick Actions */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            <TrendingUp className="h-5 w-5" />
                            Quick Actions
                        </CardTitle>
                        <CardDescription>
                            Common administrative tasks
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div className="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
                            <Link
                                href="/admin/category/create"
                                className="flex items-center gap-2 rounded-lg border p-3 hover:bg-accent transition-colors"
                            >
                                <Package className="h-4 w-4" />
                                <span className="text-sm font-medium">Add Category</span>
                            </Link>

                            <Link
                                href="/admin/brand/create"
                                className="flex items-center gap-2 rounded-lg border p-3 hover:bg-accent transition-colors"
                            >
                                <Tag className="h-4 w-4" />
                                <span className="text-sm font-medium">Add Brand</span>
                            </Link>

                            {isSuperAdmin && (
                                <Link
                                    href="/admin/roles/create"
                                    className="flex items-center gap-2 rounded-lg border p-3 hover:bg-accent transition-colors"
                                >
                                    <Shield className="h-4 w-4" />
                                    <span className="text-sm font-medium">Add Role</span>
                                </Link>
                            )}

                            <div className="flex items-center gap-2 rounded-lg border p-3 text-muted-foreground">
                                <ShoppingBag className="h-4 w-4" />
                                <span className="text-sm font-medium">Add Product</span>
                                <Badge variant="outline" className="ml-auto text-xs">Coming Soon</Badge>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}
