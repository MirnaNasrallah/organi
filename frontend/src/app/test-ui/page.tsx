// app/test-ui/page.tsx
'use client';

import React, { useState } from 'react';
import { 
  Button, 
  Input, 
  Card, 
  Badge, 
  Modal, 
  Loading 
} from '../Components/Ui';
import { 
  ShoppingCart, 
  Heart, 
  Search, 
  User, 
  Eye, 
  EyeOff,
  Star,
  Package,
  Truck,
  AlertCircle
} from 'lucide-react';

export default function TestUIPage() {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const [inputValue, setInputValue] = useState('');
  const [inputError, setInputError] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    setInputValue(value);
    
    // Simple validation example
    if (value.length > 0 && value.length < 3) {
      setInputError('Must be at least 3 characters');
    } else {
      setInputError('');
    }
  };

  const handleLoadingTest = () => {
    setIsLoading(true);
    setTimeout(() => setIsLoading(false), 3000);
  };

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Page Header */}
        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 mb-2">
            Organi UI Components Test
          </h1>
          <p className="text-gray-600">
            Testing all UI components for the Organi healthy shop application
          </p>
        </div>

        {/* Buttons Section */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Buttons</h2>
          
          <div className="space-y-6">
            {/* Button Variants */}
            <div>
              <h3 className="text-lg font-medium mb-3">Variants</h3>
              <div className="flex flex-wrap gap-3">
                <Button variant="primary">Primary</Button>
                <Button variant="secondary">Secondary</Button>
                <Button variant="outline">Outline</Button>
                <Button variant="ghost">Ghost</Button>
                <Button variant="danger">Danger</Button>
              </div>
            </div>

            {/* Button Sizes */}
            <div>
              <h3 className="text-lg font-medium mb-3">Sizes</h3>
              <div className="flex flex-wrap items-center gap-3">
                <Button size="sm">Small</Button>
                <Button size="md">Medium</Button>
                <Button size="lg">Large</Button>
              </div>
            </div>

            {/* Button States */}
            <div>
              <h3 className="text-lg font-medium mb-3">States & Icons</h3>
              <div className="flex flex-wrap gap-3">
                <Button icon={ShoppingCart}>Add to Cart</Button>
                <Button variant="outline" icon={Heart} iconPosition="right">
                  Add to Wishlist
                </Button>
                <Button loading={isLoading} onClick={handleLoadingTest}>
                  {isLoading ? 'Processing...' : 'Test Loading'}
                </Button>
                <Button disabled>Disabled</Button>
                <Button fullWidth className="mt-3">Full Width Button</Button>
              </div>
            </div>
          </div>
        </Card>

        {/* Inputs Section */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Input Fields</h2>
          
          <div className="space-y-6 max-w-md">
            <Input
              label="Basic Input"
              placeholder="Enter your name"
              helper="This is a helper text"
            />
            
            <Input
              label="Email Address"
              type="email"
              placeholder="you@example.com"
              leftIcon={User}
              value={inputValue}
              onChange={handleInputChange}
              error={inputError}
            />
            
            <Input
              label="Search Products"
              placeholder="Search for healthy foods..."
              leftIcon={Search}
              rightIcon={Search}
              onRightIconClick={() => alert('Search clicked!')}
            />
            
            <Input
              label="Password"
              type={showPassword ? 'text' : 'password'}
              placeholder="Enter password"
              rightIcon={showPassword ? EyeOff : Eye}
              onRightIconClick={() => setShowPassword(!showPassword)}
            />
            
            <Input
              label="Full Width Input"
              placeholder="This input takes full width"
              fullWidth
            />
          </div>
        </Card>

        {/* Cards Section */}
        <div className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Cards</h2>
          
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {/* Basic Card */}
            <Card>
              <h3 className="font-semibold mb-2">Basic Card</h3>
              <p className="text-gray-600">
                This is a basic card with default padding and shadow.
              </p>
            </Card>

            {/* Hover Card */}
            <Card hover clickable onClick={() => alert('Card clicked!')}>
              <h3 className="font-semibold mb-2">Hover Card</h3>
              <p className="text-gray-600">
                This card has hover effects and is clickable.
              </p>
            </Card>

            {/* Product Card Example */}
            <Card hover className="overflow-hidden">
              <div className="h-32 bg-gradient-to-br from-green-400 to-green-600 mb-4 -m-4 mb-4"></div>
              <div className="space-y-2">
                <div className="flex justify-between items-start">
                  <h3 className="font-semibold">Organic Smoothie</h3>
                  <Badge variant="success">New</Badge>
                </div>
                <p className="text-sm text-gray-600">
                  Fresh organic ingredients blended to perfection.
                </p>
                <div className="flex items-center justify-between">
                  <span className="text-lg font-bold text-primary-600">$12.99</span>
                  <Button size="sm" icon={ShoppingCart}>Add</Button>
                </div>
              </div>
            </Card>
          </div>
        </div>

        {/* Badges Section */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Badges</h2>
          
          <div className="space-y-4">
            <div>
              <h3 className="text-lg font-medium mb-3">Variants</h3>
              <div className="flex flex-wrap gap-2">
                <Badge variant="primary">Primary</Badge>
                <Badge variant="secondary">Secondary</Badge>
                <Badge variant="success">Success</Badge>
                <Badge variant="warning">Warning</Badge>
                <Badge variant="danger">Danger</Badge>
                <Badge variant="info">Info</Badge>
              </div>
            </div>

            <div>
              <h3 className="text-lg font-medium mb-3">Sizes</h3>
              <div className="flex flex-wrap items-center gap-2">
                <Badge size="sm">Small</Badge>
                <Badge size="md">Medium</Badge>
                <Badge size="lg">Large</Badge>
              </div>
            </div>

            <div>
              <h3 className="text-lg font-medium mb-3">Usage Examples</h3>
              <div className="flex flex-wrap gap-2">
                <Badge variant="success">✓ Organic</Badge>
                <Badge variant="info">🥗 Vegan</Badge>
                <Badge variant="warning">🌶️ Spicy</Badge>
                <Badge variant="primary">📦 In Stock</Badge>
                <Badge variant="danger">🔥 Limited</Badge>
              </div>
            </div>
          </div>
        </Card>

        {/* Modal Section */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Modal</h2>
          <div className="space-y-4">
            <Button onClick={() => setIsModalOpen(true)}>
              Open Modal
            </Button>
            
            <Modal
              isOpen={isModalOpen}
              onClose={() => setIsModalOpen(false)}
              title="Sample Modal"
              size="md"
            >
              <div className="space-y-4">
                <p className="text-gray-600">
                  This is a sample modal dialog. You can put any content here.
                </p>
                
                <div className="space-y-3">
                  <Input
                    label="Modal Input"
                    placeholder="Type something..."
                    fullWidth
                  />
                  
                  <div className="flex justify-end space-x-2">
                    <Button variant="ghost" onClick={() => setIsModalOpen(false)}>
                      Cancel
                    </Button>
                    <Button onClick={() => setIsModalOpen(false)}>
                      Confirm
                    </Button>
                  </div>
                </div>
              </div>
            </Modal>
          </div>
        </Card>

        {/* Loading Section */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Loading States</h2>
          
          <div className="space-y-6">
            <div>
              <h3 className="text-lg font-medium mb-3">Spinner</h3>
              <div className="flex items-center gap-4">
                <Loading variant="spinner" size="sm" />
                <Loading variant="spinner" size="md" />
                <Loading variant="spinner" size="lg" />
              </div>
            </div>

            <div>
              <h3 className="text-lg font-medium mb-3">Dots</h3>
              <div className="flex items-center gap-4">
                <Loading variant="dots" size="sm" />
                <Loading variant="dots" size="md" />
                <Loading variant="dots" size="lg" />
              </div>
            </div>

            <div>
              <h3 className="text-lg font-medium mb-3">Pulse</h3>
              <div className="flex items-center gap-4">
                <Loading variant="pulse" size="sm" />
                <Loading variant="pulse" size="md" />
                <Loading variant="pulse" size="lg" />
              </div>
            </div>
          </div>
        </Card>

        {/* Component Combinations */}
        <Card className="mb-8">
          <h2 className="text-xl font-semibold mb-4">Component Combinations</h2>
          
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {/* Notification Card */}
            <Card className="border-l-4 border-l-primary-500">
              <div className="flex items-start space-x-3">
                <div className="flex-shrink-0">
                  <Badge variant="info" size="sm">
                    <AlertCircle className="h-3 w-3 mr-1" />
                    Notice
                  </Badge>
                </div>
                <div className="flex-1">
                  <h3 className="font-medium">Order Status Update</h3>
                  <p className="text-sm text-gray-600 mt-1">
                    Your organic meal kit is being prepared for delivery.
                  </p>
                  <div className="mt-3 flex space-x-2">
                    <Button size="sm" variant="outline">
                      View Details
                    </Button>
                    <Button size="sm" variant="ghost">
                      Dismiss
                    </Button>
                  </div>
                </div>
              </div>
            </Card>

            {/* Stats Card */}
            <Card>
              <div className="flex items-center justify-between">
                <div>
                  <h3 className="font-medium text-gray-600">Total Orders</h3>
                  <p className="text-2xl font-bold text-primary-600">142</p>
                </div>
                <div className="flex items-center space-x-2">
                  <Badge variant="success">+12%</Badge>
                  <Package className="h-8 w-8 text-gray-400" />
                </div>
              </div>
            </Card>
          </div>
        </Card>

        {/* Footer */}
        <div className="text-center py-8">
          <p className="text-gray-600">
            All components are working correctly! 🎉
          </p>
        </div>
      </div>
    </div>
  );
}