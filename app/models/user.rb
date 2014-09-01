class User < ActiveRecord::Base
  validates :name, presence: true
  validates :url, presence: true
  validates_uniqueness_of :name
end
